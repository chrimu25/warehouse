<?php

namespace App\Http\Livewire\Manager;

use App\Models\Item;
use App\Models\Slot;
use App\Models\Unity;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Slots extends Component
{
    use LivewireAlert;
    public $newName, $search = '', $perPage = 5;
    public $size, $price, $category;
    public $selected_id, $open = false;
    use WithPagination;
    public $queryString = [
        'search'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'size'=>'required|integer|min:1',
            'category'=>'required',
            'price'=>'integer|required'
        ]);
    }

    public function store()
    {
        $this->validate([
            'size'=>'required|integer|min:1',
            'category'=>'required',
            'price'=>'integer|required'
        ]);
        $wh = Warehouse::findOrFail(Auth::user()->warehouse->id);
        if ($wh->slots()->count() >= $wh->num_of_slots) {
            $this->alert('error', 'Your Have Limited Number of Slots!, '.$wh->num_of_slots.' Reached', [
                'position' => 'center',
                'timer' => 4000,
                'toast' => true,
            ]);
            return;
        }
        Slot::create([
            'size'=>$this->size,
            'price'=>$this->price,
            'category_id'=>$this->category,
            'warehouse_id'=>Auth::user()->warehouse->id,
        ]);
        $this->alert('success', 'Slot inserted Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
        ]);
        $this->reset();
    }

    public function edit($id)
    {
        $slot = Slot::findOrFail($id);
        $this->newName = $slot->name;
        $this->size = $slot->size;
        $this->price = $slot->price;
        $this->category = $slot->category_id;
        $this->selected_id = $slot->id;
        $this->open = true;
    }

    public function update($id)
    {
        $slot = Slot::findOrFail($id);

        $this->validate([
            'size'=>'required|integer|min:1',
            'price'=>'required|integer|min:1'
        ]);

        $slot->category_id = $this->category;
        $slot->price = $this->price;
        $slot->size = $this->size;
        $slot->save();
        $this->reset();
        $this->open = false;
    }

    public function delete($id)
    {
        $slot = Slot::findOrFail($id);
        if($slot->products->count()>0){
            $this->alert('error', 'This slot contains some products!', [
                'position' => 'center',
                'timer' => 4000,
                'toast' => true,
            ]);
            return;
        }
        $slot->delete();
    }

    public function render()
    {
        $categories = Auth::user()->warehouse->categories;

        $slots = Slot::with('warehouse','category')
        ->where('warehouse_id',Auth::user()->warehouse->id)
        ->where('name','like','%'.trim($this->search).'%')
        ->orderBy('name')->simplePaginate($this->perPage);
    
        return view('livewire.manager.slots', compact('slots','categories'));
    }
}
