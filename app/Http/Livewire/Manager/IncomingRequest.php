<?php

namespace App\Http\Livewire\Manager;

use App\Models\Product;
use App\Models\Slot;
use App\Models\User;
use App\Notifications\RequestApprovedNotification;
use App\Notifications\RequestRejectedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class IncomingRequest extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $searchKey = '', $perPage, $item, $status;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'status'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function delete($id)
    {
        $item = Product::findOrfail($id);
        $item->delete();
        session()->flash('success','Product Deleted Successfully!');
    }

    public function Deny($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status'=>'Denied',
            'incharge'=>Auth::id()
        ]);
        $user = User::findOrFail($product->owner->id);
        $user->notify(new RequestRejectedNotification($product));
        $this->alert('success', 'Storage Request Rejected Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
    }
    
    public function Approve($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status'=>'Approved',
            'incharge'=>Auth::id(),
            'created_at'=>Carbon::now(),
        ]);
        $slot = Slot::findOrFail($product->slot->id)->update(['taken'=>1]);
        $user = User::findOrFail($product->owner->id);
        $user->notify(new RequestApprovedNotification($product));
        $this->alert('success', 'Storage Request Approved Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
    }

    public function render()
    {
        $items = Product::with('owner','category','unity','incharge1','item')
                        ->where('status', '!=','Approved')
                        ->where('warehouse_id',Auth::user()->warehouse->id)
                        ->where('out',0)
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner', function($query2){
                               $query2->where('name','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('phone','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('email','like','%'.$this->searchKey.'%'); 
                            });
                        })
                        ->when($this->status, function($query3){
                            $query3->where('status',$this->status); 
                        })
                        ->orderBy('created_at')
                        ->paginate($this->perPage);
        $all = Product::where('status', '!=','Approved')
                        ->where('warehouse_id',Auth::user()->warehouse->id)
                        ->where('out',0)->count();
        $pending = Product::where('status','Pending')
                        ->where('warehouse_id',Auth::user()->warehouse->id)
                        ->where('out',0)->count();
        $denied = Product::where('status','Denied')
                        ->where('warehouse_id',Auth::user()->warehouse->id)
                        ->where('out',0)->count();
        return view('livewire.manager.incoming-request',compact('items','all','pending','denied'));
    }
}
