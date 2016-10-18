<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GoodCreateRequest extends Request
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
            'name'=>'required',
            'marketprice'=>'required|numeric',
            'model'=>'required',
            'pic'=>'required',
            'costpirce'=>'numeric',
            'viprice'=>'numeric',
            'keyword'=>'required',
            'status'=>'required',
            'stock.region.*'=>'required',
            'stock.num.*'=>'required|integer',
            'numbering'=>'required|alpha_num|unique:anchong_goods_specifications,goods_numbering'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'请输入商品名',
            'model.required' =>'请输入型号',
            'pic.required'=>'货品图片必须上传',
            'marketprice.required'=>'请输入市场价',
            'marketprice.numeric'=>'市场价必须为数值',
            'costpirce.numeric'=>'成本价必须为数值',
            'viprice.numeric'=>'会员价必须为数值',
            'status.required'=>'请选择商品状态',
            'keyword.required'=>'关键字为后续搜索做准备，必填!',
            'stock.region.*.required'=>'请输入仓库地址',
            'stock.num.*.required'=>'请输入库存数量',
            'stock.num.*.integer'=>'库存数必须是一个整数',
            'numbering.required'=>'请填写商品编号',
            'numbering.alpha_num'=>'商品编号只能包含字母或数字',
            'numbering.unique'=>'商品编号已经存在了或请不要刷新页面进行重复表单提交',
        ];
    }
}
