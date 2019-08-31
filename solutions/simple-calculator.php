<?php

function evaluate(string $input) : int
{
    // TODO: handle parentheses
    $queue = parse($input);
    return calculate($queue);
}

function calculate(array $queue) : int
{
    $stack = [];
    while (count($queue)) {
        $token = array_shift($queue);
        if (is_numeric($token)) {
            array_push($stack, $token);
        } else {
            $right_operand = intval(array_pop($stack));
            $left_operand = intval(array_pop($stack));
            $result = apply_operation($left_operand, $right_operand, $token);
            array_push($stack, $result);
        }
    }
    return $stack[0];
}

function parse(string $input) : array
{
    $output_queue = [];
    $operator_stack = [];

    // Parse input token
    for ($i = 0; $i < strlen($input); $i++) {
        $token = $input[$i];
        // Skip white spaces
        if ($token === ' ') {
            continue;
        }
        // if is a number
        if (is_numeric($token)) {
            array_push($output_queue, $token);
        }
        // is is operator
        if (is_operator($token)) {
            $top_operator = (string)$operator_stack[0];
            $top_precedence = precedence($top_operator);
            $token_precedence = precedence($token);

            if ($token_precedence >= $top_precedence) {
                array_pop($operator_stack);
                if ($top_operator) {
                    array_push($output_queue, $top_operator);
                }
            }

            array_push($operator_stack, $token);
        }
    }

    // Generate output queue
    while (count($operator_stack)) {
        $operator = array_pop($operator_stack);
        array_push($output_queue, $operator);
    }

    return $output_queue;
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
    if ($operator === '(' || $operator ===')') {
        return 4;
    }
    return 0;
}

function is_operator(string $token) : bool
{
    return in_array($token, ['+', '-', '*', '/', '(', ')']);
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
    }
}

var_dump(
    // evaluate('- (3 + ( 2 - 1 ) )')
    evaluate('- 3 + 2 - 1')
);
