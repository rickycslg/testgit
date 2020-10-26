<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';
/*****************************   测试开始 *************************************************/
function checkBracket(string $str)
{
    if (!$str) return false;
    $arr = str_split($str);
    $left = ['{', '[', '('];// 左括号集合
    $right = ['}', ']', ')'];// 右括号集合
    $stack = [];// 栈集合
    $res = [];// 结果集合

    while (count($arr) > 0) {
        $shift = array_shift($arr);// 获取第一个字符
        if (in_array($shift, $left, true)) {
            array_push($stack, $shift);// 把出现的左括号放入栈中
        } else if (in_array($shift, $right, true)) {
            $endVal = end($stack);// 取出最后一个判断是否匹配
            if (isset($endVal) && !empty($endVal)) {
                // 通过对应的key值相同，判断是否为对应的括号
                if (array_search($shift, $right, true) === array_search($endVal, $left, true)) {
                    array_pop($stack);// 出栈
                    array_push($res, $endVal . $shift);// 将结果存入数组中
                } else {
                    return false;
                }
            }
        }
    }
    return empty($res) ? false : $res;
}

function is_valid_brackets($str){
    $Symbol = array('('=>')','['=>']','{'=>'}');
    $Stack = array();//存放匹配到的括号
    foreach(str_split($str) as $key=>$val){
        if(in_array($val,array_keys($Symbol))){
            array_push($Stack,$val);//压入数组
        }
        if(in_array($val,array_values($Symbol))){
            if($val != @$Symbol[array_pop($Stack)]){
                return false;
            }
        }
    }
    return empty($Stack)?true:false;
}

$test = '12(3{4})5';
var_dump(is_valid_brackets($test));

die;
/*****************************   测试结束 *************************************************/

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
