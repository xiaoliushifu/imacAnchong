<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreReleaseRequest extends Request
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
            'tag'=>'required',
            'title'=>'required',
            'content'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'tag.required'=>'请选择标签',
            'title.required'=>'请填写标题',
            'content.required'=>'请填写内容'
        ];
    }
}
