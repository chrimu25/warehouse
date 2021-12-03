<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\WarehousesRequest;
use App\Models\Category;
use App\Models\Cell;
use App\Models\District;
use App\Models\Province;
use App\Models\Sector;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WarehousesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehousesRequest $request)
    {
        if ($request->hasFile('image')) {
            $imgName = Str::slug($request->name).time().'.'.$request->image->extension();
            $image = $request->image->storeAs('Warehouses',$imgName,'public');
        } else{
            $image = NULL;
        }

        $warehouse = Warehouse::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'type'=>$request->type,
            'province_id'=>$request->province, 
            'district_id'=>$request->district, 
            'sector_id'=>$request->sector, 
            'cell_id'=>$request->cell,
            'category_id'=>$request->filled('category')?$request->category:NULL,
            'owner'=>$request->owner,
            'fork_lifter'=>$request->fork_lifter,
            'num_of_slots'=>$request->slots,
            'picture'=>$image
        ]);

        $user = User::create([
            'name'=>$request->mname,
            'email'=>$request->memail,
            'password'=>Hash::make('manager@password'),
            'phone'=>$request->mphone,
            'role'=>'Manager',
            'warehouse_id'=>$warehouse->id,
            'nid'=>null,
        ]);

        return back()->with('success','Warehouse Inserted Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $wh)
    {
        return view('admin.single-warehouse',compact('wh'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $wh)
    {
        $categories = Category::select('name','id')->orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        $sectors = Sector::orderBy('name')->get();
        $cells = Cell::orderBy('name')->get();
        return view('admin.create-edit-warehouse',compact('categories','provinces','districts',
        'sectors','cells','wh'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $wh)
    {
        $this->validate($request,[
            'name'=>'bail|required|string|unique:warehouses,name,'.$wh->id.'|max:60',
            'phone'=>'required|string|size:10|unique:warehouses,phone,'.$wh->id.'',
            'email'=>'email|required|string|max:120|unique:warehouses,email,'.$wh->id.'',
            'category'=>'nullable|integer',
            'type'=>'required|string',
            'owner'=>'nullable|string|min:3|max:255',
            'fork_lifter'=>'nullable|integer',
            'slots'=>'required|integer|min:1|max:5000',
            'image'=>'nullable|image|mimes:png,jpg,webp,svg|max:600',
        ]);
        if ($request->hasFile('image')) {
            if ($wh->picture) {
                Storage::disk('public')->delete($wh->picture);
            }
            $imgName = Str::slug($request->name).time().'.'.$request->image->extension();
            $image = $request->image->storeAs('Warehouses',$imgName,'public');
        } else{
            $image = $wh->picture;
        }

        $wh->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'type'=>$request->type,
            'category_id'=>$request->category,
            'owner'=>$request->owner,
            'fork_lifter'=>$request->fork_lifter,
            'num_of_slots'=>$request->slots,
            'picture'=>$image
        ]);

        session()->flash('success',$wh->code.' Updated Successfully!');
        return redirect()->route('admin.warehouses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
