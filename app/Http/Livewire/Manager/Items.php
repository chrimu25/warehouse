<?php

namespace App\Http\Livewire\Manager;

use App\Models\Product;
use App\Models\Slot;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
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
        deleteProduct($id);
        $this->alert('success', 'Product Deleted Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
    }

    public function mount($item)
    {
        $this->item = $item;
    }

    public function moveOut($id)
    {
        moveOutItem($id);
        $this->alert('success', 'product Moved Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
    }

    public function render()
    {
        $items = Product::with('owner','category','unity','incharge1','item')
                        ->where('item_id',$this->item->id)
                        ->where('warehouse_id',Auth::user()->warehouse->id)
                        ->where('status','!=','Denied')
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
        return view('livewire.manager.items', compact('items'));
    }
}
