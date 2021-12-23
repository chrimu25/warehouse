<?php

namespace App\Http\Livewire\Manager;

use App\Models\Activity;
use App\Models\Product;
use App\Models\Slot;
use App\Models\Transfer;
use App\Models\User;
use App\Notifications\TrasnsferRequestApproved;
use App\Notifications\TrasnsferRequestDenied;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class SingleClient extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $user, $previous;

    public function mount($user)
    {
        $this->user = $user;
        $this->previous = URL::previous();
    }

    public function deleteCheckout($id)
    {
      DeleteCheckout($id);
      $this->alert('success', 'Activity Deleted Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
    }

    public function deleteCheckin($id)
    {
      DeleteCheckin($id);
      $this->alert('success', 'Activity Deleted Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
    }

    public function DenyCheckout($id)
    {
        DenyCheckout($id);
        $this->alert('success', 'Checkout Request Rejected Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
    }

    public function DenyCheckin($id)
    {
        DenyCheckin($id);
        $this->alert('success', 'Checkin Request Rejected Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
    }

    public function ApproveCheckout($id)
    {
        ApproveCheckout($id);
        $this->alert('success', 'Checkout Request Approved Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
    }

    public function ApproveCheckin($id)
    {
        ApproveCheckin($id);
        $this->alert('success', 'Checkin Request Approved Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
    }

    public function deleteOutgoing($id)
    {
        deleteOutgoing($id);
        $this->alert('success', 'Transfer Request Deleted Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
    }

    public function ApproveOutgoing($id)
    {
        ApproveOutgoing($id);
        $this->alert('success', 'Transfer Allowed Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
        return redirect($this->previous);
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
        return redirect($this->previous);
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
        return redirect($this->previous);
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

    public function moveOut($id)
    {
        moveOutItem($id);
        $this->alert('success', 'product Moved Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
        return redirect($this->previous);
    }

    public function DenyRequest($id)
    {
        DenyRequest($id);
        $this->alert('success', 'Storage Request Rejected Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
    }
    
    public function ApproveRequest($id)
    {
        approveRequest($id);
        $this->alert('success', 'Storage Request Approved Successfully!', [
            'position' => 'center',
            'timer' => 4000,
            'toast' => true,
            'width' => '700',
        ]);
    }

    public function render()
    {
        $wh = Auth::user()->warehouse->id;
        $requests = Product::with('owner','category','unity','incharge1','item')->
                    where('warehouse_id',$wh)->where('owner_id',$this->user->id)->where('out',0)
                    ->where('status','Pending')->orderByDesc('created_at')->limit(15)->get();
        $checkins = Activity::with('user','product')->
                    where('warehouse_id',$wh)->where('user_id',$this->user->id)
                    ->where('type','Checkin')->orderByDesc('created_at')->limit(15)->get();
        $checkouts = Activity::with('user','product')->
                    where('warehouse_id',$wh)->where('user_id',$this->user->id)
        ->where('type','Checkout')->orderByDesc('created_at')->limit(15)->get();
        $incoming = Transfer::with('owner1','fromWarehouse','unity','slot','product')->
                    where('to',$wh)->where('owner',$this->user->id)->where('approved',1)
                    ->orderByDesc('created_at')->limit(15)->get();
        $outgoing = Transfer::with('owner1','fromWarehouse','unity','slot','product')->
                    where('from',$wh)->where('owner',$this->user->id)
        ->orderByDesc('created_at')->limit(15)->get();
        return view('livewire.manager.single-client', compact(
            'requests',
            'checkins',
            'checkouts',
            'incoming',
            'outgoing',
        ));
    }
}
