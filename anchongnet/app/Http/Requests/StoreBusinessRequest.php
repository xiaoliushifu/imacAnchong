<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreBusinessRequest extends Request
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
            'title'=>'required',
            'content'=>'required',
            'tag'=>'required',
            'phone'=>'required',
            'type'=>'required',
            'area'=>'required',
            'endtime'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'请填写标题',
            'content.required'=>'请填写内容',
            'tag.required'=>'请选择标签',
            'phone.required'=>'请填写联系电话',
            'type.required'=>'请选择类型',
            'area.required'=>'请选择区域',
            'endtime.required'=>'请填写结束时间',
        ];
    }
}
