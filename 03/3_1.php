<?php

$subject = file_get_contents('data3_1.txt');

$pattern = '#(mul)\((\d{1,3}),(\d{1,3})\)#s';
$matches = [];
preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$result = 0;
foreach ($matches as $match) {
    print_r($match);
    list($full, $op, $_1, $_2) = $match;
    $result += $_1 * $_2;
}
echo "Result: $result\n";
// 178538786