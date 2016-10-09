<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class PageController extends Controller
{
    /*
     *找货跳转页面
     */
    public function postFgpage()
    {
        $input = Input::get(['page']);
        return redirect('sergoods?page='.$input);
    }
     /*
     *工程跳转页面
     */
    public function postGcpage()
    {
        $input = Input::get(['page']);
        return redirect('project?page='.$input);
    }
    /*
     *人才跳转页面
     */
    public function postTlpage()
    {
        $input = Input::get(['page']);
        return redirect('talent?page='.$input);
    }
    /*
     *第三方跳转页面
     */
    public function postThpage($sid)
    {
        $input = Input::get(['page']);
        return redirect('equipment/thirdshop/'.$sid.'?page='.$input);
    }
    /*
   *设备选购跳转页面
   */
    public function postEqpage($cat_id)
    {
        $input = Input::get(['page']);
        return redirect('equipment/list/'.$cat_id.'?page='.$input);
    }
}
