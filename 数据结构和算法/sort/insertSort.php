<?php
//O(n^2)
function insertionSort($arr)
{
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) {
        $preIndex = $i - 1;
        $current = $arr[$i];
        while($preIndex >= 0 && $arr[$preIndex] > $current) {
            $arr[$preIndex+1] = $arr[$preIndex];
            $preIndex--;
        }
        $arr[$preIndex+1] = $current;
    }
    return $arr;
}
$arr = insertSort2([1,10,5,2,7,8,3,5,6,71,230]);
var_dump($arr);

function insertSort2($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        $preIndex = $i - 1;
        $current = $arr[$i];
        while($preIndex > 0 && $arr[$preIndex] > $current) {//相当于一次快排
            $arr[$preIndex+1] = $arr[$preIndex];
            $preIndex --;
        }
        $arr[$preIndex+1] = $current;
    }
    return $arr;
}