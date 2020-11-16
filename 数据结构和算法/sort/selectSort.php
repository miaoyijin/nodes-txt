<?php
//O(n^2),每次找出最小的
function selectSort($arr)
{
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) {
        $minIndex  = $i;
        for ($j = $i + 1; $j < $len; $j++) {
            if ($arr[$j] < $arr[$minIndex]) {
                $minIndex = $j;
            }
        }
        if ($minIndex != $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$minIndex];
            $arr[$minIndex] = $temp;
        }
    }
    return $arr;
}
$arr = selectSort([1,10,5,2,7,8,3,5,6,71,230]);
var_dump($arr);