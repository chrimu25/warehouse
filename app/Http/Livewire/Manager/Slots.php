<?php

namespace App\Http\Livewire\Manager;

use App\Models\Category;
use App\Models\Slot;
use App\Models\Unity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Slots extends Component
{
    public $newName, $search = '', $perPage = 5;
    public $size, $unity, $category;
    public $selected_id, $open = false;
    use WithPagination;
    public $queryString = [
        'search'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, 
        ['size'=>'required|integer|min:1']);
    }

    public function store()
    {
        $this->validate(['size'=>'required|integer|min:1']);
        Slot::create([
            'size'=>$this->size,
            'remaining'=>$this->size,
            'category_id'=>$this->category,
            'unity_id'=>$this->unity,
            'warehouse_id'=>Auth::user()->warehouse->id,
        ]);
        $this->reset();
    }

    public function edit($id)
    {
        $slot = Slot::findOrFail($id);
        $this->newName = $slot->name;
        $this->size = $slot->size;
        $this->category = $slot->category_id;
        $this->unity = $slot->unity_id;
        $this->selected_id = $slot->id;
        $this->open = true;
    }

    public function update($id)
    {
        $slot = Slot::findOrFail($id);
        $this->validate(['size'=>'required|integer|min:1']);
        $slot->size = $this->size;
        $slot->category_id = $this->category;
        $slot->unity_id = $this->unity;
        $slot->save();
        $this->reset();
        $this->open = false;
    }

    public function delete($id)
    {
        $slot = Slot::findOrFail($id);
        if ($slot->product) {
            $this->emit('alert',['type'=>'warning','message'=>'Can\'t Delete Slot! Poduct Attached']);
            return;
        }
        $slot->delete();
    }

    public function render()
    {
        $unities = Unity::select('name','id')->orderBy('name')->get();
        $categories = Category::select('name','id')->orderBy('name')->get();

        $slots = Slot::with('warehouse','category','unity')
        ->where('name','like','%'.trim($this->search).'%')
        ->orderBy('name')->simplePaginate($this->perPage);
    
        return view('livewire.manager.slots', compact('slots','unities','categories'));
    }
}
