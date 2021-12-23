<?php

use App\Models\Activity;
use App\Models\Product;
use App\Models\Slot;
use App\Models\Transfer;
use App\Models\User;
use App\Notifications\CheckinApprovedNotification;
use App\Notifications\CheckinDeniedNotification;
use App\Notifications\CheckoutApprovedNotification;
use App\Notifications\CheckoutDeniedNotification;
use App\Notifications\RequestApprovedNotification;
use App\Notifications\RequestRejectedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function ApproveCheckout($id)
{
    $activity = Activity::findOrFail($id);
        $activity->update(['status'=>'Approved']);
        $product = Product::findOrFail($activity->product_id);
        $product->update([
            'quantity'=>$product->quantity - $activity->quantity,
        ]);
        
        $user = User::findOrFail($activity->user_id);
        $user->notify(new CheckoutApprovedNotification($activity));
}

function DenyCheckout($id)
{
    $activity = Activity::findOrFail($id);
    $activity->update(['status'=>'Rejected']);
    
    $user = User::findOrFail($activity->user_id);
    $user->notify(new CheckoutDeniedNotification($activity));
}

function DeleteCheckout($id)
{
    $item = Activity::findOrfail($id);
    $item->delete();
}

function DeleteCheckin($id)
{
    $item = Activity::findOrfail($id);
    $item->delete();
}

function DenyCheckin($id)
{
    $activity = Activity::findOrFail($id);
    $activity->update(['status'=>'Rejected']);
    
    $user = User::findOrFail($activity->user_id);
    $user->notify(new CheckinDeniedNotification($activity));
}

function ApproveCheckin($id)
{
    $activity = Activity::findOrFail($id);
    $activity->update(['status'=>'Approved']);
    $product = Product::findOrFail($activity->product_id);
    $product->update([
        'quantity'=>$product->quantity + $activity->quantity,
    ]);
    
    $user = User::findOrFail($activity->user_id);
    $user->notify(new CheckinApprovedNotification($activity));
}

function deleteOutgoing($id){
    $item = Transfer::findOrfail($id);
    $item->delete();
}

function ApproveOutgoing($id){
    $transfer = Transfer::findOrFail($id);
    $transfer->update([
        'approved'=>1,
        'incharge'=>Auth::id(),
    ]);
}

function deleteProduct($id)
{
    $item = Product::findOrfail($id);
    $item->delete();
}

function moveOutItem($id)
{
    $product = Product::findOrFail($id);
    $product->update(['out'=>1, 'incharge'=>Auth::id()]);
    $slot = Slot::findOrFail($product->slot->id)->update(['taken'=>0]);
}

function DenyRequest($id)
{
    $product = Product::findOrFail($id);
    $product->update([
        'status'=>'Denied',
        'incharge'=>Auth::id()
    ]);
    $user = User::findOrFail($product->owner->id);
    $user->notify(new RequestRejectedNotification($product));
}

function approveRequest($id)
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
}
