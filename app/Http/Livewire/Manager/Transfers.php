<?php

namespace App\Http\Livewire\Manager;

use App\Models\Product;
use App\Models\Slot;
use App\Models\Transfer;
use App\Models\User;
use App\Notifications\TrasnsferRequestApproved;
use App\Notifications\TrasnsferRequestDenied;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Transfers extends Component
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
        $item = Transfer::findOrfail($id);
        $item->delete();
        session()->flash('success','Product Deleted Successfully!');
    }

    public function Deny($id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->update([
            'status'=>'Denied',
            'incharge'=>Auth::id()
        ]);
        
        $user = User::findOrFail($transfer->owner);
        $user->notify(new TrasnsferRequestDenied($transfer));
        $this->alert('success', 'Transfer Request Denied Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }
    
    public function Approve($id)
    {
        $transfer = Transfer::findOrFail($id);
        $slot = Slot::findOrFail($transfer->slot_id);
        if ($slot->taken==1) {
            $productCheck = Product::where('slot_id',$slot->id)->first();
            if ($transfer->category_id == $productCheck->category_id) {
                if ($transfer->owner == $productCheck->owner_id) {
                    $this->insertdata($transfer);
                } else{
                    $this->alert('error', 'This slot is already taken!', [
                        'position' => 'top-right',
                        'timer' => 4000,
                        'toast' => true,
                        'width' => '500',
                    ]);
                    return;
                }
            } else{
                $this->alert('error', 'Product Categories doesn\'t match!', [
                    'position' => 'top-right',
                    'timer' => 4000,
                    'toast' => true,
                    'width' => '500',
                ]);
                return;
            }
        } else{
            $this->insertdata($transfer);
        }
    }

    public function insertdata($transfer)
    {
        $transfer->update([
            'status'=>'Approved',
            'incharge'=>Auth::id()
            ]);
        $product = Product::findOrFail($transfer->product_id);
        $product->update([
            'quantity'=>$product->quantity - $transfer->quantity,
        ]);

        Product::create([
            'item_id'=>$transfer->product->item->id,
            'quantity'=>$transfer->quantity,
            'unity_id'=>$transfer->unity_id,
            'slot_id'=>$transfer->slot_id,
            'category_id'=>$transfer->category_id,
            'owner_id'=>$transfer->owner,
            'status'=>'Approved',
            'warehouse_id'=>$transfer->to,
            'incharge'=>Auth::id(),
            'transfer'=>1,
            'until'=>$transfer->until
        ]);

        $user = User::findOrFail($transfer->owner);
        $user->notify(new TrasnsferRequestApproved($transfer));
        $this->alert('success', 'Transfer Request Approved Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }

    public function render()
    {
        $transfers = Transfer::with('owner1','fromWarehouse','unity','slot','product')
                        ->where('to',Auth::user()->warehouse->id)
                        ->where('approved',1)
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner1', function($query2){
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
        $all = Transfer::where('to',Auth::user()->warehouse->id)->where('approved',1)->count();
        $pending = Transfer::where('status','Pending')
                        ->where('approved',1)
                        ->where('to',Auth::user()->warehouse->id)->count();
        $approved = Transfer::where('status','Approved')
                        ->where('approved',1)
                        ->where('to',Auth::user()->warehouse->id)->count();
        $denied = Transfer::where('status','Denied')
                        ->where('approved',1)
                        ->where('to',Auth::user()->warehouse->id)->count();
        
        return view('livewire.manager.transfers',compact('transfers','all','pending','denied','approved'));
    }
}
