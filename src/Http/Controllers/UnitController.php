<?php
/**
 * [Description]
 *
 * @Author  leeprince:2020-07-05 14:17
 */

namespace LeePrince\Unit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class UnitController extends Controller
{
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
        
        $param = empty($param) ? [] : explode('|', $param);
        $data  = call_user_func_array([$object, $action], $param);
        
        return (is_array($data)) ? json_encode($data) : dd($data);
    }
}