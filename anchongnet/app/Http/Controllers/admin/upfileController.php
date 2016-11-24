<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use DB;
use App\imgpost;
use App\Http\Controllers\Controller;

/**
*   干货文件操作
*/
class upfileController extends Controller
{
    public function getIndex(Request $req)
    {
        $u = $req['u'];
        $f = $req['f'];
        if ($u) {
            $mydata = DB::table('anchong_upfiles')->orderby('created_time','desc')->where('filenoid',$u)->paginate(10);
        } elseif ($f) {
            $mydata = DB::table('anchong_upfiles')->orderby('created_time','desc')->where('filename','like','%'.$f.'%')->paginate(10);
        } else {
            $mydata = DB::table('anchong_upfiles')->orderby('created_time','desc')->paginate(10);
        }
        $args = ['u'=>$u,'f'=>$f];
		return view('admin/permission/ganhuo',compact("mydata",'args'));
    }
    
    /**
     * 删除干货文件
     * @param Request $req
     */
    public function postDel(Request $req)
    {
        $mydata = DB::table('anchong_upfiles')->where('auid',$req['fid'])->get();
        if (!$mydata) {
           return 0; 
        }
        $img = new imgpost();
        $fn = substr($mydata[0]->filename,strrpos($mydata[0]->filename,'/')+1);
        //oss删除
        if ($img->delete($fn)) {
            //本地库删除
            DB::table('anchong_upfiles')->where('auid',$req['fid'])->delete();
            return 1;
        }
        return 0;
    }

}