<?php

$m = [];

$d = file('data2.txt');
foreach ($d as $line) {
    $tokens = explode(' ', $line);
    array_walk($tokens, 'intval');
    array_push($m, $tokens);
}
$total = count($m);

function isSafe(array $row): int {
    if (empty($row)) {
        throw new Exception('empty');
    }

    print_r($row);

    $org = $row;

    $isAsc = null;
    $last = array_shift($row);
    while ($current = array_shift($row)) {
        if (is_null($isAsc)) {
            $isAsc = $current > $last;
        } elseif ($current > $last && !$isAsc) {
            print_r('**' . __LINE__ . "\n");
            print_r($row);
            return 0;
        } elseif ($current < $last && $isAsc) {
            print_r('**' . __LINE__ . "\n");
            print_r($row);
            return 0;
        }
        $d = abs($current - $last);
        if ($d < 1 || $d > 3) {
            print_r('**' . __LINE__ . "\n");
            print_r($row);
            return 0;
        }
        $last = $current;
    }
    print_r('**' . __LINE__ . "\n");
    print_r($org);
    return 1;
}

$res = 0;
while ($lv = array_shift($m)) {
    $res += isSafe($lv);
}
echo "Result: $res / $total are safe.\n";
