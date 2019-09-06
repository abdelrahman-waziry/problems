<?php

function evaluate(string $input) : int
{
    $value_stack = [];
    $operator_stack = [];
    // Step 1
    for ($index = 0; $index < strlen($input); $index ++) {
        $token = $input[$index];
        // Skip white spaces
        if ($token === ' ') {
            continue;
        }
        // handle numbers
        if (is_numeric($token)) {
            array_push($value_stack, intval($token));
        }
        // handle left parentheses
        if ($token === '(') {
            array_push($operator_stack, $token);
        }
        // handle right parentheses
        if ($token === ')') {
            while (count($operator_stack) && $operator_stack[ count($operator_stack) - 1] !== '(') {
                do_operation($value_stack, $operator_stack);
            }
            array_pop($operator_stack);
        }
        // handle operators
        if (is_operator($token)) {
            while (count($operator_stack) && precedence($operator_stack[ count($operator_stack) - 1 ]) >= precedence($token)) {
                 do_operation($value_stack, $operator_stack);
            }
            array_push($operator_stack, $token);
        }
    }
    // Step 2
    while (count($operator_stack)) {
         do_operation($value_stack, $operator_stack);
    }
    // Step 3
    return (int) array_pop($value_stack);
}

function precedence(string $operator) : int
{
    if ($operator === '-' || $operator === '+') {
        return 1;
    }
    if ($operator === '*' || $operator === '/') {
        return 2;
    }
    if ($operator === '^') {
        return 3;
    }
    return 0;
}

function is_operator(string $token) : bool
{
    return in_array($token, ['+', '-', '*', '/', '^']);
}

function do_operation(array &$value_stack, array &$operator_stack) : void
{
    $operator = array_pop($operator_stack);
    $right_operand = (int)array_pop($value_stack);
    $left_operand = (int)array_pop($value_stack);
    $value = apply_operation($left_operand, $right_operand, $operator);
    array_push($value_stack, $value);
}

function apply_operation(int $left_operand, int $right_operand, string $operator) : int
{
    switch ($operator) {
        case '+':
            return $left_operand + $right_operand;
        case '-':
            return $left_operand - $right_operand;
        case '/':
            return $left_operand / $right_operand;
        case '*':
            return $left_operand * $right_operand;
        case '^':
            return pow($left_operand, $right_operand);
    }
}

var_dump(
    evaluate('- (3 + ( 2 - 1 ) )'),
    evaluate('- 2 * 5 + 6 / 3'),
    evaluate('- 3 + 2 - 1'),
    evaluate('- 2 ^ 5 * 2')
);
