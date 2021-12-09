<?php

namespace App\Http\Livewire\Manager;

use App\Models\Product;
use App\Models\Slot;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

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

    public function moveOut($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['out'=>1]);
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
