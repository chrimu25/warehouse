<?php

namespace App\Http\Livewire\Manager;

use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use App\Models\Slot;
use App\Models\Unity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InsertItems extends Component
{
    use LivewireAlert;
    protected $listeners = ['InsertItemsComponent' => '$refresh'];
    
    public $users, $products, $slots, $items, $owner, $quantity1;

    public function mount()
    {
        $user_wh = Auth::user()->warehouse;
        $this->users = User::where('role','Client')->select('name','id')->orderBy('name')->get();
        if ($user_wh->type=="Single") {
            $this->products = Item::where('id',$user_wh->item_id)->select('name','id')
            ->orderBy('name')->get();
        } else{
            $this->products = Item::select('name','id')->orderBy('name')->get();
        }
        $this->slots = Auth::user()->slots()->with('unity')
        ->orderBy('slots.name')->get();
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
            'items.*.item'=>'required',
            'items.*.slot'=>'required',
            'items.*.quantity'=>'required|integer|lt:items.*.maxQuantity',
            'items.*.duration'=>'required|date|after:'.Carbon::now(),
        ]);

        
    }

    public function updatedItems($value,$key)
    {
        
        $parts = explode(".",$key);
        if ($parts[1] == "slot") {
            $this->quantity1 = Slot::where('id',$value)->pluck('remaining')->first();
            $this->items[$parts[0]] = [
                'item' => $this->items[$parts[0]]['item'],
                'maxQuantity' => $this->quantity1,
                'slot' => $this->items[$parts[0]]['slot'],
            ];
        }
    }

    public function store()
    {
        $this->validate([
            'owner'=>'bail|required',
            'items.*.item'=>'required',
            'items.*.slot'=>'required',
            'items.*.quantity'=>'required|integer|lt:items.*.maxQuantity',
            'items.*.duration'=>'required|date|after:'.Carbon::now(),
        ]);
        
        foreach($this->items as $key=>$item){
            $slot = Slot::findOrFail($item['slot']);
            if ($slot) {
                $product = Product::create([
                    'item_id'=>$item['item'],
                    'quantity'=>$item['quantity'],
                    'owner_id'=>$this->owner,
                    'status'=>'Approved',
                    'warehouse_id'=>Auth::user()->warehouse->id,
                    'incharge'=>Auth::id(),
                    'until'=>$item['duration']
                ]);
                $slot->update(['remaining'=>$slot->remaining - $product->quantity]);
                $slot->products()->sync($product);
            } else{
                continue;
            }
        }
        $this->alert('success', 'Items Inserted Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
        return redirect()->route('manager.products');
    }

    public function render()
    {
        return view('livewire.manager.insert-items');
    }
}
