<?php

function find_pythagorean_triplet(array $input) : bool
{
    // Check count
    if (count($input) < 3) {
        return false;
    }

    // Sort array
    rsort($input);

    // Search for triplets
    for ($i=0; $i < count($input) - 2; $i++) {
        $slice = array_slice($input, $i, 3);
        $difference = pow($slice[0], 2) - pow($slice[1], 2) - pow($slice[2], 2);
        if ($difference === 0) {
            return true;
        }
    }

    return false;
}

 var_dump(
     find_pythagorean_triplet([10, 4, 6, 12, 5])
 );
