<?php
$a = function (Closure $next)
{
    echo 'a';
    $next();
};

$b = function (Closure $next)
{
    echo 'b';
    $next();
};
$init = function () {
    echo 'init';
};
function callPack(Closure $closure, $targetF) {
    //把变量和函数封装在一起当成一个整体，保留运行环境
    return function () use ($closure, $targetF) {$targetF($closure);};
};
$go1 = callPack($init, $a);
$go = callPack($go1, $b);
$go();