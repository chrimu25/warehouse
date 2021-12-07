<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Activity;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivitiesController extends Controller
{
    public function checkin(Product $item)
    {
        return view('client.single-checkin', compact('item'));
    }

    public function checkout(Product $item)
    {
        return view('client.single-checkout', compact('item'));
    }

    public function insertCheckin(Request $request, Product $item)
    {
        $this->validate($request, [
            'newQuantity'=>'required|integer',
        ]);
        Activity::create([
            'user_id'=>Auth::id(),
            'product_id'=>$item->id,
            'warehouse_id'=>$item->warehouse_id,
            'quantity'=>$request->newQuantity,
            'old_quantity'=>$item->quantity,
            'type'=>'Checkin',
            'status'=>'Pending',
        ]);

        return redirect()->route('client.items');
    }

    public function insertCheckout(CheckoutRequest $request, Product $item)
    {
        Activity::create([
            'user_id'=>Auth::id(),
            'product_id'=>$item->id,
            'warehouse_id'=>$item->warehouse_id,
            'quantity'=>$request->newQuantity,
            'old_quantity'=>$item->quantity,
            'type'=>'Checkout',
            'status'=>'Pending',
        ]);

        return redirect()->route('client.items');
    }
}
