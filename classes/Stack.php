<?php

$stack = new SplStack();
//LIFO
//check bracers balance
$str = '((1 + 3) * (9 + 1) * 7)';
for ($i = 0, $len = mb_strlen($str); $i < $len; $i++) {
    $char = $str[$i];
    if ($char == '(' || $char == ')') {
        if ($stack->current() == $char || $stack->isEmpty()) {
            $stack->push($char);
        } else {
            if (!$stack->isEmpty()) {
                $stack->pop();
            }
        }
    }
}

if (count($stack) == 0) {
    echo 'Balanced';
} else {
    echo 'Unbalanced';
}