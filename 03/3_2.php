<?php

$subject = file_get_contents('data3_1.txt');

$pattern = '#do\(\)|don\'t\(\)|mul\((\d{1,3}),(\d{1,3})\)#s';
$matches = [];
preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$result = 0;
$enabled = true;
foreach ($matches as $match) {
    print_r($match);
    @list($full, $_1, $_2) = $match;
    switch ($full) {
        case 'don\'t()':
            $enabled = false;
            break;
        case 'do()':
            $enabled = true;
            break;
        default:
            if ($enabled) {
                $result += $_1 * $_2;
            }
            break;
    }
}
echo "Result: $result\n";
