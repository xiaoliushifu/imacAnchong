<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Cache;

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
            //定义当前时间
            $nowtime=time()+10;
            //查出当前促销时间段
            $endpromotion_id=DB::table('anchong_promotion')->where('end_time','<',$nowtime)->pluck('promotion_id');
            //判断有没有过期的促销时段
            if($endpromotion_id){
                $result=\App\Http\Controllers\admin\PromotionController::endpromotion($endpromotion_id[0]);
                DB::table('anchong_promotion')->where('end_time','<',$nowtime)->delete();
                //判断是否有促销缓存
                if (Cache::has('anchong_promotion_goods'))
                {
                    //删除缓存
                    Cache::forget('anchong_promotion_goods');
                }
            }
            //查出当前促销时间段
            $promotion_id=DB::table('anchong_promotion')->where('start_time','<',$nowtime)->where('end_time','>',$nowtime)->pluck('promotion_id');
            if($promotion_id){
                $result=\App\Http\Controllers\admin\PromotionController::promotion($promotion_id[0]);
            }
     })->daily();
    }
}
