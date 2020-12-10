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
    return function () use ($closure, $targetF) {$targetF($closure);};
};
$go = $init;

foreach ([$a, $b] as $f) {
    $go = callPack($go, $f);
}
$go();