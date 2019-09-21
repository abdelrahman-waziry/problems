<?php

function is_non_decreasing($nums) : bool
{
    $changes = 0;
    $size = count($nums);
    for ($i = 1; $i < $size && $changes <=1; $i++) {
        if ($nums[$i - 1] > $nums[$i]) {
            $changes ++;
            // case like this [ 4 | 6 | `5` ] => [ 4 | 5 | 5 ]
            if ($i == 1 || $nums[$i - 2] <= $nums[$i]) {
                $nums[$i-1] = $nums[$i];
            } else { // case like this [ 4 | 6 | `3` ] => [ 4 | 6 | 6]
                $nums[$i] = $nums[$i - 1];
            }
        }
    }
    return $changes <= 1;
}

var_dump(
    is_non_decreasing([3,4,2,3])
);
