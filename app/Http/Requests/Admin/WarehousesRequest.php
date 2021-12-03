<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WarehousesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes(){
        return [
            'name'=>'Warehouse Name',
            'phone'=>'Incharge\'s Phone Number',
            'email'=>'Incharge\'s Email Address',
            'category'=>'Product Category',
            'type'=>'Warehouse Type',
            'owner'=>'Owner',
            'fork_lifter'=>'Fork Lifters',
            'slots'=>'Slots/ Section',
            'mname'=>'Manager Name',
            'mphone'=>'Manager Phone',
            'memail'=>'Manager Email Address'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'bail|required|string|unique:warehouses,name|max:60',
            'phone'=>'required|string|size:10|unique:warehouses,phone',
            'email'=>'email|required|string|max:120|unique:warehouses,email',
            'category'=>'nullable',
            'type'=>'required|string',
            'owner'=>'nullable|string|min:3|max:255',
            'fork_lifter'=>'integer|nullable',
            'slots'=>'required|integer|min:1|max:5000',
            'province'=>'required|integer',
            'district'=>'required|integer|lte:field',
            'sector'=>'required|integer',
            'cell'=>'required|integer',
            'image'=>'nullable|image|mimes:png,jpg,webp,svg|max:600',
            'mname'=>'required|string|min:3|max:255',
            'mphone'=>'required|string|unique:users,phone|size:10',
            'memail'=>'required|email|string|unique:users,email'
        ];
    }
}
