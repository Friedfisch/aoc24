<?php

$l = [];
$r = [];

$d = file('data1.txt');
foreach ($d as $line) {
    $tokens = explode(' ', $line);
    array_push($l, (int) array_shift($tokens));
    array_push($r, (int) array_pop($tokens));
}

sort($l);
sort($r);

$res = 0;
while ($lv = array_shift($l)) {
    $rv = array_shift($r);
    $res += abs($lv - $rv);
}
echo "Result: $res\n";
