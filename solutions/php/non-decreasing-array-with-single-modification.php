<?php

function is_non_decreasing($input) : bool
{
    $size = count($input);
    $changes = 0;
    $i = 1;
    while ($changes <= 1 && $i < $size) {
        if ($input[$i] > $input[$i+1]) {
            $changes ++;
        }
        $i ++;
    }
    return $changes <= 1;
}

$input1 = [13, 4, 7];
$input2 = [5,1,3,2,5];

var_dump(
    is_non_decreasing($input2)
);
