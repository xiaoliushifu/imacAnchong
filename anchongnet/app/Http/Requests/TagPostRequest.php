<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TagPostRequest extends Request
{
    protected $redirect='/tag/create';
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
            'type'=>'required',
            'tag'=>'required|unique:anchong_tag',
        ];
    }

    public function messages()
    {
        return [
            'type.required'=>'类型必须填写',
            'tag.required' => '标签名称必须填写',
            'tag.unique'=>'该标签已经添加过了,不必重复添加'
        ];
    }
}
