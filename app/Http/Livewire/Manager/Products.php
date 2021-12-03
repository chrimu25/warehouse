<?php

namespace App\Http\Livewire\Manager;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Products extends Component
{
    public $product, $newName, $search = '', $perPage = 5;
    public $selected_id, $open = false;
    use WithPagination;
    public $queryString = [
        'search'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields,
        ['product'=>'required|string|max:100|min:3|unique:categories,name']);
    }

    public function store()
    {
        $this->validate(['product'=>'required|string|max:100|min:3|unique:categories,name']);
        Item::create([
            'name'=>$this->product,
            'slug'=>Str::slug($this->product)
        ]);
        $this->reset();
    }

    public function edit($id)
    {
        $product = Item::findOrFail($id);
        $this->product = $product->name;
        $this->newName = $product->name;
        $this->selected_id = $product->id;
        $this->open = true;
    }

    public function update($id)
    {
        $product = Item::findOrFail($id);
        $this->validate(['product'=>'required|string|unique:categories,name,'.$product->id]);
        $product->name = $this->product;
        $product->slug = Str::slug($this->product);
        $product->save();
        $this->reset();
        $this->open = false;
    }

    public function delete($id)
    {
        $product = Item::findOrFail($id);
        if ($product->stockin->count() > 0) {
            $this->emit('alert',['type'=>'warning','message'=>'Can\'t Delete Item! Products Attached']);
            return;
        }
        $product->delete();
    }

    public function render()
    {
        $products = Item::withCount([
            'stockin'=>function($query){
                $query->where('warehouse_id',Auth::user()->warehouse->id);
            }
            ])
        ->where('name','like','%'.trim($this->search).'%')
        ->orderBy('name')->simplePaginate($this->perPage);
        return view('livewire.manager.products', compact('products'));
    }
}
