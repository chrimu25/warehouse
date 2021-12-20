<?php

namespace App\Http\Livewire\Manager;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Invoices extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $searchKey = '', $perPage, $item, $confirmed = '';
    public $queryString = [
        'searchKey'=>['except'=>''],
        'confirmed'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function confirm($id)
    {
        $invoice = Invoice::findOrFail($id)->update(['confirmed'=>1]);
        $this->alert('success', 'Invoice Confirmed Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }


    public function render()
    {
        $items = Invoice::with('owner','product')->where('warehouse_id',Auth::user()->warehouse->id)
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner', function($query2){
                               $query2->where('name','like','%'.$this->searchKey.'%')
                               ->orWhere('phone','like','%'.$this->searchKey.'%')
                               ->orWhere('email','like','%'.$this->searchKey.'%'); 
                            });
                        })
                        ->when($this->confirmed, function($query3){
                            $query3->where('confirmed',$this->confirmed); 
                        })
                        ->orderByDesc('created_at')
                        ->paginate($this->perPage);
        return view('livewire.manager.invoices', compact('items'));
    }
}
