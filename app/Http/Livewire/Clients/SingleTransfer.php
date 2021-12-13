<?php

namespace App\Http\Livewire\Clients;

use App\Models\Category;
use App\Models\District;
use App\Models\Slot;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Warehouse;
use App\Notifications\TransferRequestNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SingleTransfer extends Component
{
    use LivewireAlert;
    public $item;
    public $warehouses, $slots; 
    public $location;
    public $category;
    public $unity;
    public $slot;
    public $warehouse;
    public $until;
    public $quantity;
    public $startingDate;
    public $enddate;
    public $oldQuantity;
    public $oldWarehouse;

    public function mount($item)
    {
        $this->item = $item;
        $this->oldQuantity = $item->quantity;
        $this->category = $item->category_id;
        $this->unity = $item->unity_id;
        $this->oldWarehouse = $item->warehouse_id;
    }

    public function updatedWarehouse($warehouse)
    {
        if (!is_null($warehouse)) {
            $this->slots = Slot::where('warehouse_id',$warehouse)
            ->where('category_id',$this->category)
            ->where('taken',0)
            ->select('name','id')->get();
        }
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'quantity'=>'required|integer|lte:oldQuantity',
            'location'=>'required',
            'warehouse'=>'required|after_or_equal:date',
            'slot'=>'required',
            'startingDate'=>'required|date|after_or_equal:'.date('Y-m-d'),
            'enddate'=>'bail|required|after_or_equal:startingDate',
        ]);
    }

    public function store()
    {
        $this->validate([
            'quantity'=>'required|integer|lte:oldQuantity',
            'location'=>'required',
            'warehouse'=>'required|after_or_equal:date',
            'slot'=>'required',
            'startingDate'=>'required|date|after_or_equal:'.Carbon::now(),
            'enddate'=>'bail|required|after_or_equal:startingDate',
        ]);
        
        $transfer = Transfer::create([
            'from'=>$this->oldWarehouse,
            'to'=>$this->warehouse,
            'slot_id'=>$this->slot,
            'product_id'=>$this->item->id,
            'category_id'=>$this->category,
            'unity_id'=>$this->unity,
            'owner'=>Auth::id(),
            'until'=>$this->enddate,
            'quantity'=>$this->quantity,
        ]);

        $user = User::findOrFail($transfer->fromWarehouse->manager->id);
        $user->notify(new TransferRequestNotification($transfer));
        $this->reset();
        $this->alert('success', 'Transfer Submitted Successfully!', [
            'position' => 'top-end',
            'timer' => 4000,
            'width' => '600',
            'toast' => true,
        ]);
        return redirect()->route('client.items');
    }
    
    public function render()
    {
        if(!is_null($this->location)){
            $this->warehouses = Warehouse::where('district_id',$this->location)
            ->where('id','!=',$this->oldWarehouse)
            ->orderBy('name')->select('name','id')->get();
        }
        
        $locations = District::whereHas('warehouse')->select('districts.name','districts.id')
        ->orderBy('districts.name')->get();
        $categories = Category::select('name','id')->orderBy('name')->get();
        return view('livewire.clients.single-transfer', compact('locations','categories'));
    }
}
