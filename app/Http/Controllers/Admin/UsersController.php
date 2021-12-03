<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function EditManagers(User $user)
    {
        $warehouses = Warehouse::select('name','id')->orderBy('name')->get();
        return view('admin.edit-manager', compact('user','warehouses'));
    }

    public function UpdateManager(Request $request, User $user)
    {
        $attributes = [
            'warehouse'=>'Warehouse',
            'name'=>'manager Full Name',
        ];
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|min:3|max:200',
            'email'=>'email|string|required|min:4|max:200|unique:users,email,'.$user->id,
            'phone'=>'string|size:10|unique:users,phone,'.$user->id,
            'warehouse'=>'nullable',
        ],$attributes);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        $request->has('status')?$status=1:$status=0;
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'warehouse_id'=>$request->warehouse,
            'status'=>$status,
        ]);

        session()->flash('success',$user->name.' Updated Successfully');

        return redirect()->route('admin.managers');
    }
}
