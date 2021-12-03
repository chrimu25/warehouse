<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Managers\ItemsRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use App\Models\Unity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    public function create()
    {
        
        return view('manager.create-edit-item');
    }

    // public function store(ItemsRequest $request)
    // {
    //     foreach($request->items as $item){
    //         Product::create([
    //             'name'=>$item['name'],
    //             'quantity'=>$item['quantity'],
    //             'owner_id'=>$request->owner,
    //             'category_id'=>$item['category'],
    //             'unity_id'=>$item['unity'],
    //             'warehouse_id'=>Auth::user()->warehouse->id,
    //             'incharge'=>Auth::id(),
    //             'duration'=>$item['duration']
    //         ]); 
    //     }

    //     session()->flash('success',' Items Inserted Successfully!');

    //     return redirect()->route('manager.products');
    // }

    public function show(Item $item)
    {
        return view('manager.items', compact('item'));
    }
}
