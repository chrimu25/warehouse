<?php

namespace App\Http\Livewire\Manager;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;
    public $searchKey = '', $perPage = 10, $item;
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

    public function mount($item)
    {
        $this->item = $item;
    }

    public function render()
    {
        $items = Product::with('owner','category','unity','slot','incharge','item')
                        ->where('item_id',$this->item->id)
                        ->orWhere('quantity','like','%'.$this->searchKey.'%')
                        ->orWhere('duration','like','%'.$this->searchKey.'%')
                        ->orderByDesc('created_at')
                        ->paginate($this->perPage);
        return view('livewire.manager.items', compact('items'));
    }
}
