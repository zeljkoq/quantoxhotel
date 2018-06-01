<?php
$arr = [
    'a' => 'apple',
    'b' => 'banana',
    'c' => 'cherry'
];
while (list($var, $val) = each($arr)) {
    echo "$var is $val" . PHP_EOL;
}