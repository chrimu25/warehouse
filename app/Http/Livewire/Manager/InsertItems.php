<?php

namespace App\Http\Livewire\Manager;

use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use App\Models\Slot;
use App\Models\Unity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InsertItems extends Component
{
    protected $listeners = ['InsertItemsComponent' => '$refresh'];
    
    public $users, $unities, $categories, $products, $slots, $items, $owner, $quantity1;

    public function mount()
    {
        $this->users = User::where('role','Client')->select('name','id')->orderBy('name')->get();
        $this->unities = Unity::select('name','id')->orderBy('name')->get();
        $this->products = Item::select('name','id')->orderBy('name')->get();
        $this->categories = Category::select('name','id')->orderBy('name')->get();
        $this->slots = Slot::select('name','id')->orderBy('name')->get();
        $this->items = [[]];
    }

    public function addNewRow()
    {
        $this->items[] = [];
    }

    public function removeRow($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'owner'=>'bail|required',
            'items.*.item'=>'required|distinct',
            'items.*.quantity'=>'required|integer',
            'items.*.unity'=>'required|integer',
            'items.*.duration'=>'required|integer',
        ]);
    }

    public function store()
    {
        $this->validate([
            'owner'=>'bail|required',
            'items.*.item'=>'required|distinct',
            'items.*.quantity'=>'required|integer',
            'items.*.unity'=>'required|integer',
            'items.*.duration'=>'required|integer',
        ],[
            
        ]);
        foreach($this->items as $key=>$item){
            // $product = Product::create([
            //     'item_id'=>$item['item'],
            //     'quantity'=>$item['quantity'],
            //     'owner_id'=>$this->owner,
            //     'category_id'=>$item['category'],
            //     'unity_id'=>$item['unity'],
            //     'status'=>'Approved',
            //     'warehouse_id'=>Auth::user()->warehouse->id,
            //     'incharge'=>Auth::id(),
            //     'duration'=>$item['duration']
            // ]);
            // $slots->products()->sync($product);
            $slots = Auth::user()->slots->where('category_id',$item['category'])
            ->where('unity_id',$item['unity'])->sum('remaining', 'as','remaining_size');
            dd($slots);
            // ->where('category_id',$item['category'])
            // ->where('unity_id',$item['unity'])->orderByDesc('remaining')->get();
            // // // dd($slots->count());
            // $this->quantity1 = 0;
            // foreach($slots as $slot){
            //     $this->quantity1 += $slot->remaining;
            // }
            
            // if ($this->quantity1 >= $item['quantity']) {
            //     foreach($slots as $slot){
            //         $stock =$item['quantity'] ;
            //         while($stock>0){
            //             if($slot->remaining >= $stock){
            //                 Product::create([
            //                     'item_id'=>$item['item'],
            //                     'quantity'=>$stock,
            //                     'owner_id'=>$this->owner,
            //                     'category_id'=>$item['category'],
            //                     'unity_id'=>$item['unity'],
            //                     'status'=>'Approved',
            //                     'warehouse_id'=>Auth::user()->warehouse->id,
            //                     'incharge'=>Auth::id(),
            //                     'duration'=>$item['duration']
            //                 ]);
            //                 $slot->update([
            //                     'remaining' => $slot->remaining -$stock,
            //                 ]);
            //                 unset($this->items[$key]);
            //                 $this->items = array_values($this->items);
            //                 // break;
            //             }else{
            //                 Product::create([
            //                     'item_id'=>$item['item'],
            //                     'quantity'=>$slot->remaining,
            //                     'owner_id'=>$this->owner,
            //                     'category_id'=>$item['category'],
            //                     'unity_id'=>$item['unity'],
            //                     'status'=>'Approved',
            //                     'warehouse_id'=>Auth::user()->warehouse->id,
            //                     'incharge'=>Auth::id(),
            //                     'duration'=>$item['duration']
            //                 ]);
            //                 $slot->update([
            //                     'remaining' => 0,
            //                 ]);
            //             }
            //             $stock -= $slot->remaining;
            //             // $stock
            //         }
            //         //uns
            //             //break
                    
            //     }
            // } else{
            //     session()->flash('insert-error','Our Slot is not enough! only '.$this->quantity1.' short to store '.$item['quantity']);
            //     return;
            // }
        }

        session()->flash('success',' Items Inserted Successfully!');

        return redirect()->route('manager.products');
    }

    public function render()
    {
        return view('livewire.manager.insert-items');
    }
}
