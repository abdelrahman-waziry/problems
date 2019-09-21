<?php

function sort_nums(array $nums) : array
{
    $size = count($nums);
    $result = [];

    $i = 0;
    $lo = 0;
    $hi = $size - 1;

    while ($i < $size) {
        if ($nums[$i] === 1) {
            $result[$lo ++] = 1;
            $result[$lo] = 2;
        }
        if ($nums[$i] === 3) {
            $result[$hi--] = 3;
            $result[$hi] = 2;
        }
        $i ++;
    }

    return $result;
}

$nums =  [3, 3, 2, 1, 3, 2, 1];
$sorted = sort_nums($nums);
ksort($sorted);
var_dump($sorted);
