<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreLogisRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|unique:anchong_shops_logistics',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'请填写物流名称',
            'name.unique' => '该物流名称已经存在了'
        ];
    }
}
