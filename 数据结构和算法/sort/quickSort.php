<?php
/**
 * 迭代版递归O(nlogn)
 * @param $a
 * @param $begin
 * @param $end
 */
function mySort(&$a, $begin, $end)
{
    if ($begin < $end) {
        $key = $a[$begin];
        $i = $begin;
        $j = $end;
        while ($i < $j) {
            //从右边开始找出第一个大于i的
            while ($i < $j && $a[$j] > $key) {
                $j--;
            }
            if ($i < $j) {
                $a[$i] = $a[$j];
                $i++;
            }
            while ($i < $j && $a[$i] < $key) {
                $i++;
            }
            if ($i < $j) {
                $a[$j] = $a[$i];
                $j++;
            }
        }
        $a[$i] = $key;
        $begin < $i && mySort($a, $begin, $i);
        $i + 1 < $end && mySort($a, $i+1, $end);

    }
}
$a = [1,10,5,2,7,8,3];
mySort($a, 0, count($a) - 1);
print_r($a);


