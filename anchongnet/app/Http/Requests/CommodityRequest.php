<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommodityRequest extends Request
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
            'name'=>'required|unique:anchong_goods,title',
            "pic"=>'required',
        ];
    }

    public function messages(){
        return [
            'name.unique'=>'该商品已经存在了或请不要刷新页面进行重复表单提交',
            "pic.required"=>'商品图片必须上传',
        ];
    }
}
