# leeprince/laravel-unit 组件

基于 laravel 开发的单元测试组件

## 版本说明

laravel >= 6.0 & php >= 7.2


## 安装方式

composer require leeprincne/laravel-unit


## 配置方式
该组件的 composer.json 中已加入以下部分，所以在项目根目录的 config/app.php 的 providers 数组中无需加入 ShineYork\JunitLaravel\JunitServiceProvide::class, 否则需要加入 

```angular2
    "extra":{
        "laravel":{
            "providers":[
                "ShineYork\\JunitLaravel\\JunitServiceProvide"
            ]
        }
    }
```

## 路由说明
```
<?php
/**
 * [已在组件中定义路由前缀为： unit； 所以访问以下路径需要添加前缀 unit]
 *
 * @Author  leeprince:2020-07-05 14:59
 */

route::get('/', 'UnitController@index');
route::post('/', 'UnitController@request')->name('unit.request');
```