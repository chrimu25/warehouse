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
    
    public $users, $unities, $products, $slots, $items, $owner, $quantity1;

    public function mount()
    {
        $categories = json_encode(Auth::user()->warehouse->categories->pluck('id'));
        $cats=[];
        foreach(json_decode($categories) as $key=>$cat){
            $cats[] = $cat;
        }
        $user_wh = Auth::user()->warehouse;
        $this->users = User::where('role','Client')->select('name','id')->orderBy('name')->get();
        $this->products = Item::select('name','id')
        ->whereIn('category_id',$cats)
        ->orderBy('name')->get();
        $this->unities = Unity::select('name','id')->orderBy('name')->get();
        $this->slots = Auth::user()->slots()->where('slots.taken',0)->orderBy('slots.name')->get();
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
            'items.*.quantity'=>'required|integer',
            'items.*.duration'=>'required|date|after:'.Carbon::now(),
        ]);

        
    }

    public function store()
    {
        $this->validate([
            'owner'=>'bail|required',
            'items.*.item'=>'required',
            'items.*.slot'=>'required',
            'items.*.quantity'=>'required|integer',
            'items.*.duration'=>'required|date|after:'.Carbon::now(),
        ]);
        
        foreach($this->items as $key=>$item){
            $item1 = Item::findOrFail($item['item']);
            
            $product = Product::create([
                'item_id'=>$item['item'],
                'quantity'=>$item['quantity'],
                'unity_id'=>$item['unity'],
                'slot_id'=>$item['slot'],
                'category_id'=>$item1->category->id,
                'owner_id'=>$this->owner,
                'status'=>'Approved',
                'warehouse_id'=>Auth::user()->warehouse->id,
                'incharge'=>Auth::id(),
                'until'=>$item['duration']
            ]);

            $slot1 = Slot::findOrFail($item['slot']);
            $slot1->update(['taken'=>1]);
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
