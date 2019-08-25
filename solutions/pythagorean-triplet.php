<?php
// TODO: send sub-array to are_pythagorean_triplet
// TODO: divide and conquer the input array from both sides

function find_pythagorean_triplet(array $input) : bool
{
    $input = array_unique($input);

    if (count($input) < 3) {
        return false;
    }

    rsort($input);

    $first_index = 0;
    $second_index = 1;
    $third_index = 2;

    for ($i=0; $i < count($input) - 2; $i++) {
        $first = $input[$first_index ++];
        $second = $input[$second_index ++];
        $third = $input[$third_index ++];
        if (are_pythagorean_triplet($first, $second, $third)) {
            return true;
        }
    }

    return false;
}

function are_pythagorean_triplet(int $first, int $second, int $third) : bool
{
    return (pow($first, 2) - pow($second, 2) - pow($third, 2)) === 0;
}

 var_dump(
     find_pythagorean_triplet([1,2,3])
 );
