<?php
/**
 * [单元测试组件的服务提供者： laravel 项目的组件加载大部分都是通过服务提供者引导]
 *
 * @Author  leeprince:2020-07-05 15:07
 */

namespace LeePrince\Unit;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * [单元测试服务提供者]
 *  可以借鉴：基于 laravel 开发的组件：laravel-admin、telescope
 *
 * @Author  leeprince:2020-07-06 18:25
 * @package LeePrince\Unit
 */
class UnitServiceProvider extends ServiceProvider
{
    public function register()
    {
        // dump('这是单元测试的服务提供者');
        $this->registerConfigFilePublishing();
    }
    
    /**
     * [引导服务：该方法在所有服务提供者被注册以后才会被调用]
     *
     * @Author  leeprince:2020-03-22 19:55
     */
    public function boot()
    {
        $this->loadRoutes();
        $this->loadViews();
    }
    
    /**
     * [加载路由]
     *
     * @Author  leeprince:2020-03-23 00:28
     */
    private function loadRoutes()
    {
        Route::group(['namespace' => 'LeePrince\Unit\Http\Controllers', 'prefix' => 'unit', 'middleware' => 'web'], function() {
            $this->loadRoutesFrom(__DIR__.'/Route/route.php');
            
            // laravel 版本 <= 5.3 以下版本
            // require __DIR__.'/Route/route.php';
        });
    }
    
    /**
     * [加载视图]
     *
     * @Author  leeprince:2020-03-24 01:08
     */
    private function loadViews()
    {
        $this->loadViewsFrom(__DIR__."/Resources/views/", 'unitview');
    }
    
    /**
     * [执行 vendor:publish 命令发布配置文件到指令目录，即可以发布配置文件到指定目录，达到允许外部修改配置文件信息的目的]
     *      执行：php artisan vendor:publish --provider="LeePrince\Unit\UnitServiceProvider"
     *
     * @Author  leeprince:2020-03-25 00:43
     */
    private function registerConfigFilePublishing()
    {
        // 确定应用程序是否正在控制台中运行。
        if ($this->app->runningInConsole()) {
            /**
             * 注册要由 publish 命令发布的路径，可以发布配置文件到指定目录;
             *      config_path()
             *          1. 不填就是默认的地址 config_path 的路径, 发布配置文件名不会改变;
             *          2. 不带后缀就是一个文件夹
             *          3. 如果是一个后缀就是一个文件
             *      publishes() 的第二个参数是这个配置文件的标识，可以为null或者任意字符
             */
            $this->publishes([__DIR__ . '/Resources/assets' => public_path('/vendor/leeprince/laravel-unit/')], null);
        }
    }
}