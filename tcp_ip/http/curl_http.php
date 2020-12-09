<?php
/**
 * tcp粘包处理,测试结果客户端可以正确处理数据【服务端也可以处理粘包】
 * Created by PhpStorm.
 * User: mouyj
 * Date: 2020/12/8
 * Time: 19:37
 */
error_reporting(E_ALL);
ini_set('display_errors', 'on');
function HTTP_Post($URL,$data, $referrer="") {

    $result = $request = '';
    // parsing the given URL
    $URL_Info=parse_url($URL);
    $URL_Info["port"]=80;
    // building POST-request:
    $request.="GET ".$URL_Info["path"]." HTTP/1.1\r\n";
    $request.="Host: ".$URL_Info["host"]."\r\n";
    $request.="Content-type: application/x-www-form-urlencoded\r\n";
    $request.="Connection: keep-alive\r\n";
    $request.="\r\n\r\n";
    $request.="GET ".$URL_Info["path"]." HTTP/1.1\r\n";
    $request.="Host: ".$URL_Info["host"]."\r\n";
    $request.="Content-type: application/x-www-form-urlencoded\r\n";
    $request.="Connection: close\r\n";
    $request.="\r\n\r\n";
    $fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
    fputs($fp, $request);
    fputs($fp, $request);
    $except=null;
    //定义超时时间
    $time_out=null;
    //socket_select($r = [$fp],$r = [],$except, $time_out);
    while ($c = fgets($fp, 1024)) {//此处应该配合socket_select
        echo time() . PHP_EOL;//为什么会阻塞应为feof,不适合判断tcp数据流所以会一直阻塞直到超时才返回结果内容，fgets 也是阻塞的,只因为上面的Connection: keep-alive，如果改成close则会迅速获得数据并返回
        $result .= $c;
    }
    fclose($fp);
    return $result;
}

$output1=HTTP_Post("http://www.2345.com/404/404.html",$_POST);

echo $output1;
?>