<?php

namespace App\Http\Requests\Managers;

use Illuminate\Foundation\Http\FormRequest;

class ItemsRequest extends FormRequest
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

    public function attributes()
    {
        return [
            'owner'=>'Product Owner',
            'name'=>'Item Name',
            'quantity'=>'Quantity',
            'unity'=>'Unity',
            'duration'=>'Duration',
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
            'owner'=>'bail|required',
            'name.*'=>'string|min:3|max:120',
            'quantity.*'=>'required|integer',
            'unity.*'=>'required|integer',
            'duration.*'=>'required|integer',
        ];
    }
}
