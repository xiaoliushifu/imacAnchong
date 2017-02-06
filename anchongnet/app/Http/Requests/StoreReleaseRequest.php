<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreReleaseRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * 表单请求类验证，后台验证，前台由jquery插件来完成
     * 如果是ajax请求，则验证失败时返回422 Unprocessable Entity，还有一个包含错误信息的json字符串
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
