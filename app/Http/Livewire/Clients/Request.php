<?php

namespace App\Http\Livewire\Clients;

use App\Models\Category;
use App\Models\District;
use App\Models\Item;
use App\Models\Product;
use App\Models\Slot;
use App\Models\Unity;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Request extends Component
{
    use LivewireAlert;

    public $products, $districts, $categories, $warehouses, $slots, $unities;
    public $item; 
    public $product; 
    public $district = null; 
    public $category; 
    public $quantity; 
    public $unity;
    public $warehouse = null; 
    public $slot;
    public $until;

    public function mount()
    {
        $this->unities = Unity::select('name','id')->orderBy('name')->get();
        $this->categories = Category::select('name','id')->orderBy('name')->get();
        $this->districts = District::whereHas('warehouse')->select('districts.name','districts.id')
                                ->orderBy('districts.name')->get();
        $this->warehouses = null;
        $this->slots = null;
    }

    public function updatedCategory($category)
    {
        if (!is_null($category)) {
            $this->products = Item::where('category_id',$category)->select('name','id')->orderBy('name')->get();;
        }
    }

    public function updatedDistrict($district)
    {
        if (!is_null($district)) {
            $this->warehouses = Warehouse::where('district_id',$district)
                               ->orderBy('warehouses.name')->select('name','id')->get();
        }
    }

    public function updatedWarehouse()
    {
        if (!is_null($this->warehouse) && !empty($this->category)) {
            $this->slots = Slot::where('warehouse_id',$this->warehouse)
                            ->where('category_id',$this->category)
                            ->select('name','id','size','price')
                            ->get();
        }
    }
    
    public function insert()
    {
        Product::create([
            'item_id'=>$this->item,
            'quantity'=>$this->quantity,
            'status'=>'Pending',
            'owner_id'=>Auth::id(),
            'category_id'=>$this->category,
            'unity_id'=>$this->unity,
            'slot_id'=>$this->slot,
            'warehouse_id'=>$this->warehouse,
            'until'=>$this->until,
        ]);

        $this->alert('success', 'Request Submitted Successfully!', [
            'position' => 'top-end',
            'timer' => 4000,
            'width' => '600',
            'toast' => true,
        ]);

        return redirect()->route('client.items');
    }

    public function render()
    {
        return view('livewire.clients.request');
    }
}
