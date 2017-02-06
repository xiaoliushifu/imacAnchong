<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Cache;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            //取得当前时间
            $nowtime=time()+10;
            error_log(date('Y-m-d H:i:s')." schedule start\r\n",3,storage_path().'/logs/schedule.log');
            //判定有无要结束的旧促销
            $endpromotion_id=DB::table('anchong_promotion')->where('end_time','<',$nowtime)->pluck('promotion_id');
            if ($endpromotion_id) {
                //结束促销
                $result=\App\Http\Controllers\admin\PromotionController::endpromotion($endpromotion_id[0]);
                DB::table('anchong_promotion')->where('end_time','<',$nowtime)->delete();
                Cache::forget('anchong_promotion_goods');
                Cache::forget('anchong_promotion_time');
            }
            //查看是否有要开启的新促销
            $promotion_id=DB::table('anchong_promotion')->where('start_time','<',$nowtime)->where('end_time','>',$nowtime)->pluck('promotion_id');
            if ($promotion_id) {
                $result=\App\Http\Controllers\admin\PromotionController::promotion($promotion_id[0]);
            }
            //顺便把订单确认收货的也办了
            $order_id_arr=DB::table('anchong_goods_order')->select('order_id')->where('state',3)->where('updated_at','<',date('Y-m-d H:i:s',($nowtime-864000)))->get();
            if ($order_id_arr) {
                $result=\App\Http\Controllers\admin\orderController::confirm($order_id_arr);
            }
            error_log(date('Y-m-d H:i:s')." schedule end\r\n",3,storage_path().'/logs/schedule.log');
        })->daily();
<<<<<<< HEAD
		//})->everyMinute();
=======
>>>>>>> a271849f8a3b24b30fe096df2299cd0c5d29d44b
    }
}
