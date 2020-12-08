<?php
/**
 * [单元测试控制器 - laravel 版本大于 5.5 使用]
 *
 * @Author  leeprince:2020-07-05 14:17
 */

namespace LeePrince\Unit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
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
        return view("unitview::index");
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
        
        $class  = empty($className) ? $namespace : $namespace . '\\' . $className;
        $class  = str_replace("/", '\\', $class);
        $object = new $class();
    
        $paramArr = [];
        if (!empty($param)) {
            $paramArr = explode('|', $param);
            $paramArr = array_map('trim', $paramArr);
        }
        $data  = call_user_func_array([$object, $action], $paramArr);
        
        return (is_array($data)) ? json_encode($data) : dd($data);
    }
}