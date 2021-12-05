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
    public $size, $unity, $item;
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
            'unity'=>'required',
            'item'=>'required'
        ]);
    }

    public function store()
    {
        $this->validate([
            'size'=>'required|integer|min:1',
            'unity'=>'required',
            'item'=>'required',
        ]);
        $item = Item::find($this->item)->first();
        $wh = Warehouse::findOrFail(Auth::user()->warehouse->id);
        if ($wh->type=="Single" && $wh->item_id!=$this->item) {
            $this->alert('error', 'Your warehouse has no ability to store '.$item->name, [
                'position' => 'center',
                'timer' => 4000,
                'toast' => true,
            ]);
        } else if(($wh->type=="Single" && $wh->item_id == $this->item) || 
        (Auth::user()->warehouse->type=="Multiple")){
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
                'remaining'=>$this->size,
                'item_id'=>$this->item,
                'unity_id'=>$this->unity,
                'warehouse_id'=>Auth::user()->warehouse->id,
            ]);
        }
        $this->reset();
    }

    public function edit($id)
    {
        $slot = Slot::findOrFail($id);
        $this->newName = $slot->name;
        $this->size = $slot->size;
        $this->item = $slot->item_id;
        $this->unity = $slot->unity_id;
        $this->selected_id = $slot->id;
        $this->open = true;
    }

    public function update($id)
    {
        $item = Item::find($this->item)->first();
        $wh = Warehouse::findOrFail(Auth::user()->warehouse->id);
        // dd($wh->id);
        if ($wh->type=="Single" && $wh->item_id!=$this->item) {
            $this->alert('error', 'Your warehouse has no ability to store '.$item->name, [
                'position' => 'center',
                'timer' => 4000,
                'toast' => true,
            ]);
        } else if(($wh->type=="Single" && $wh->item_id == $this->item) || 
        (Auth::user()->warehouse->type=="Multiple")){
        $slot = Slot::findOrFail($id);
        $this->validate(['size'=>'required|integer|min:1']);
        $slot->item_id = $this->item;
        $slot->unity_id = $this->unity;
        $slot->save();
        $this->reset();
        $this->open = false;
        }
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
        $items = Item::select('name','id')->orderBy('name')->get();

        $slots = Slot::with('warehouse','item','unity')
        ->where('name','like','%'.trim($this->search).'%')
        ->orderBy('name')->simplePaginate($this->perPage);
    
        return view('livewire.manager.slots', compact('slots','unities','items'));
    }
}
