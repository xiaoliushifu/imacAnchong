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
            'backselect'=>'required',
            'name'=>'required',
            'spetag'=>'required',
            'marketprice'=>'required|numeric',
            'costpirce'=>'numeric',
            'viprice'=>'numeric',
            'status'=>'required',
            'stock.region.*'=>'required',
            'stock.num.*'=>'required|integer',
            'pic.*'=>'image',
            'detailpic.*'=>'image',
            'parampic.*'=>'image',
            'datapic.*'=>'image',
            'numbering'=>'required|alpha_num'
        ];
    }

    public function messages()
    {
        return [
            'backselect.required'=>'请选择分类',
            'name.required'=>'请输入商品名',
            'spetag.required'=>'请输入规格标签',
            'marketprice.required'=>'请输入市场价',
            'marketprice.numeric'=>'市场价必须为数值',
            'costpirce.numeric'=>'成本价必须为数值',
            'viprice.numeric'=>'会员价必须为数值',
            'status.required'=>'请选择商品状态',
            'stock.region.*.required'=>'请输入仓库地址',
            'stock.num.*.required'=>'请输入库存数量',
            'stock.num.*.integer'=>'库存数必须是一个整数',
           // 'pic.*.required'=>'请上传至少一张商品图片',
            'pic.*.image'=>'商品图片请上传(jpeg, png, bmp, gif 或 svg)类型的文件',
          //  'detailpic.*.required'=>'请上传至少一张详情图片',
            'detailpic.*.image'=>'详情图片请上传(jpeg, png, bmp, gif 或 svg)类型的文件',
          //  'parampic.*.required'=>'请上传至少一张参数图片',
            'parampic.*.image'=>'参数图片请上传(jpeg, png, bmp, gif 或 svg)类型的文件',
            //'datapic.*.required'=>'请上传至少一张相关资料图片',
            'datapic.*.image'=>'相关资料图片请上传(jpeg, png, bmp, gif 或 svg)类型的文件',
            'numbering.required'=>'请填写商品编号',
            'numbering.alpha_num'=>'商品编号只能包含字母或数字',
        ];
    }
}
