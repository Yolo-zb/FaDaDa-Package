<?php

/**
 * Created by PhpStorm.
 * User: ZhuoBin
 * Date: 2019/6/17
 * Time: 上午10:43
 */
namespace Zhuobin\FaDaDa\Src;

use Illuminate\Support\ServiceProvider;


class FaDaDaProvider extends ServiceProvider
{
    public function boot()
    {
        $this->register();
    }

    public function register()
    {
        //注册helper
        $this->app->singleton('FaDaDa', function () {
            return new FaBigBigOrigin();
        });
    }
}