<?php
/**
 * [ 路由 ]
 * 已在组件中定义路由前缀为： unit； 所以访问以下路径需要添加前缀 unit
 *
 * @Author  leeprince:2020-07-05 14:59
 */

route::get('/', 'UnitController@index');
route::post('/', 'UnitController@request')->name('unit.request');