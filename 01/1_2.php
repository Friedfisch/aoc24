<?php

$l = $r = $d = [];

//$l = [3, 4, 2, 1, 3, 3];
//$r = [4, 3, 5, 3, 9, 3];

$d = file('data1.txt');
foreach ($d as $line) {
    $tokens = explode(' ', $line);
    array_push($l, (int) array_shift($tokens));
    array_push($r, (int) array_pop($tokens));
}

$mr = [];
foreach ($r as $v) {
    $mr[$v] += 1;
}

$res = 0;
while ($lv = array_shift($l)) {
    $rv = array_shift($r);
    $res += $lv * $mr[$lv];
}
echo "Result: $res\n";
