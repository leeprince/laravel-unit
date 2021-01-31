<?php
/**
 * [单元测试控制器 - laravel 版本大于 5.5 使用]
 *
 * @Author  leeprince:2020-07-05 14:17
 */

namespace LeePrince\Unit\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function __construct()
    {
        // 安全防护：环境检测，仅允许本地环境使用
        if (config('app.env') != 'local'
            || !config('app.debug')
        ) {
            dd('prince: 403 forbidden');
        }
    }
    
    /**
     * [测试窗口]
     *
     * @Author  leeprince:2020-07-05 15:07
     */
    public function index()
    {
        // dump('Unit::index');
        
        $assetPath = '/vendor/leeprince/laravel-unit';
        return view("unitview::index", ['assetPath' => $assetPath]);
    }
    
    /**
     * [单元测试请求的方法]
     *
     * @Author  leeprince:2020-07-05 14:31
     * @param Request $request
     * @return false|string
     */
    public function request(Request $request)
    {
        $namespace = $request->input('namespace');
        $className = $request->input('className');
        $action    = $request->input('action', 'index');
        $param     = $request->input('param');
    
        $request->validate([
            'namespace' => "bail|required",
        ], [
            'namespace.required' => ':attribute 是必填项！',
        ], [
            'namespace' => '「命名空间」'
        ]);
        // 关于validate验证器：laravel 低于等于 5.5 版本使用; 而且必须继承 use App\Http\Controllers\Controller;
        /*$this->validate($request, [
            'namespace' => "bail|required",
        ], [
            'namespace.required' => ':attribute 是必填项！',
        ], [
            'namespace' => '「命名空间」'
        ]);*/
    
        $object = $this->getFullClass($namespace, $className);
    
        $paramArr = $this->getParamArr($param);
    
        try {
            $data  = call_user_func_array([$object, $action], $paramArr);
            return $data;
        } catch (\Exception $e) {
            dd('捕获异常：', $e);
        }
    }
    
    /**
     * [获取请求的参数数组]
     * @param string $param
     * @return array
     */
    public function getParamArr(string $param): array
    {
        $paramArr = [];
        if (empty($param)) {
            return $paramArr;
        }
        $paramArr = explode('|', $param);
        foreach ($paramArr as &$item) {
            $item = $this->getTypeOfValue($item);
        }
        return $paramArr;
    }
    
    /**
     * [获取的类型转换后的值]
     *  强制转换同php的基本写法一致:(string/int/array)值，特别注意的是强制转为array的值必须是json字符串
     *  php 特性：数字转换为字符串类型或者整型类型 传入 字符串或者整型的类型检查是不会报错的
     */
    public function getTypeOfValue(string $value)
    {
        if (! preg_match("/\((.*)\)(.*)/", $value, $match)) {
            return $value;
        }
        $type = $match[1]; // 强制转换类型
        $noConvertValue = $match[2]; // 原始字符串数据
        if (! array_key_exists($type, self::$valueType)) {
            return $value;
        }
        $convFunc = self::$valueType[$type]; // 方法
        if ($type == self::VALUE_ARRAY) { // 强制转换为数组特殊处理
            return $convFunc($noConvertValue, true);
        }
        
        $value = $convFunc($noConvertValue);
        return $value;
    }
    
    /**
     * [获取被测试的完整类实例]
     * @param string $namespace
     * @param string $className
     * @return string
     */
    public function getFullClass(string $namespace, string $className)
    {
        $class  = empty($className) ? $namespace : $namespace . '\\' . $className;
        $class  = str_replace("/", '\\', $class);
        $class  = str_replace(";", '', $class);
        
        return new $class();
    }
}