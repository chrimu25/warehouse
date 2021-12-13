<?php

namespace App\Http\Livewire\Manager;

use App\Models\Invoice as InvoiceModel;
use App\Models\Product;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class Store extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $searchKey = '', $perPage, $item;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function delete($id)
    {
        $item = Product::findOrfail($id);
        $item->delete();
        session()->flash('success','Product Deleted Successfully!');
    }

    public function invoice($id)
    {
        $product = Product::findOrFail($id);
        $days = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->diffInDays(Carbon::createFromFormat('Y-m-d', $product->created_at->format('Y-m-d')));
        
        $customer = new Party([
            'name'          => $product->owner->name,
            'custom_fields' => [
                'Phone number' => $product->owner->phone,
                'E-mail Address' => $product->owner->email,
                'Province' => $product->owner->province?$product->owner->province->name:'',
                'District' => $product->owner->district?$product->owner->district->name:'',
                'Sector' => $product->owner->sector?$product->owner->sector->name:'',
                'Cell' => $product->owner->cell?$product->owner->cell->name:'',
            ],
        ]);

        $item = (new InvoiceItem())
        ->title($product->warehouse->code.' Warehouse, '.$product->slot->name.' Invoice')
        ->pricePerUnit($product->slot->price)
        ->quantity($days);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('Y-m-d')
            ->payUntilDays(10)
            ->currencyCode('RWF')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($customer->name.time())
            ->addItem($item)
            ->save('public');

        $link = $invoice->url();
            dd($link);
        InvoiceModel::create([
            'user_id'=>$product->owner_id,
            'product_id'=>$product->id,
            'days'=>$days,
            'total_price'=>$product->slot->price * $days,
        ]);
    }

    public function moveOut($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['out'=>1, 'incharge'=>Auth::id()]);
        $slot = Slot::findOrFail($product->slot->id)->update(['taken'=>0]);
        $this->alert('success', 'Slot Released Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
    }

    public function render()
    {
        $items = Product::with('owner','category','unity','incharge','item')
                        ->where('status','Approved')
                        ->where('warehouse_id',Auth::user()->warehouse->id)
                        ->where('out',0)
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner', function($query2){
                               $query2->where('name','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('phone','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('email','like','%'.$this->searchKey.'%'); 
                            });
                        })
                        ->orderByDesc('created_at')
                        ->paginate($this->perPage);
        return view('livewire.manager.store', compact('items'));
    }
}
