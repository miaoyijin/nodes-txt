<?php

// 定义一个接口
interface Middleware
{
    public function handle(Closure $next);
}

// 实现一个日志中间件
class LogMiddleware implements Middleware
{
    public function handle(Closure $next)
    {
        echo "log1" . '<br/>' . PHP_EOL;
        $next();
        echo "log2" . '<br/>' . PHP_EOL;
    }
}

// 实现一个验证中间件
class ApiMiddleware implements Middleware
{
    public function handle(Closure $next)
    {
        echo "token" . '<br/>' . PHP_EOL;
        $next();
    }
}

// 执行调用函数
function carry($closures, $middleware)
{
    return function () use ($closures, $middleware) {
        $middleware->handle($closures);
    };
}

// 执行调用
function then()
{
    $middlewares = [new LogMiddleware(), new ApiMiddleware()];
    // Controller中处理的的业务逻辑
    $prepare = function () {
        echo 'start' . '<br/>' . PHP_EOL;
    };
    // mixed array_reduce( array $array, callable $callback[, mixed $initial = NULL] )
    // array_reduce() 将回调函数 callback 迭代地作用到 array 数组中的每一个单元中，从而将数组简化为单一的值。

    // array array_reverse( array $array[, bool $preserve_keys = false] )
    // array_reverse — 返回单元顺序相反的数组
    $go = array_reduce(array_reverse($middlewares), 'carry', $prepare);
    $go();

}

then();
?>
