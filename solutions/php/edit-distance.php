<?php

function distance(string $first_string, string $second_string) : int
{
    $first_string_len = mb_strlen($first_string);
    $second_string_len = mb_strlen($second_string);
    $table[$first_string_len][$second_string_len] = 0;

    for ($x=0; $x <= $first_string_len; $x++) {
        for ($y = 0; $y <= $second_string_len; $y ++) {
            if ($first_string_len === 0) { // First string is empty => insert all characters of the second string
                $table[$x][$y] = $second_string_len;
            } else if ($second_string_len === 0) { // Second string is empty => delete all characters of the first string
                $table[$x][$y] = $first_string_len;
            } else if ($first_string[$x-1] === $second_string[$y-1]) { // last characters are the same => ignore and recur
                $table[$x][$y] = $table[$x-1][$y-1];
            } else { // if are not the same => consider all operations and find the minimum cost
                $insert = $table[$x][$y-1];
                $delete = $table[$x-1][$y];
                $replace = $table[$x-1][$y-1];
                $table[$x][$y] = 1 + min($insert, $delete, $replace);
            }
        }
    }

    return $table[$first_string_len][$second_string_len];
}

var_dump(
    distance('biting', 'sitting')
);
