<?php

$m = [];

$d = file('data2_1.txt');
foreach ($d as $line) {
    $tokens = explode(' ', $line);
    array_walk($tokens, 'intval');
    array_push($m, $tokens);
}
$total = count($m);

function isSafe(array $row): bool {
    $isAsc = null;
    $last = null;
    foreach ($row as $current) {
        if (is_null($last)) {
            $last = $current;
            continue;
        }
        if (is_null($isAsc)) {
            $isAsc = $current > $last;
        } elseif ($current > $last && !$isAsc) {
            return false;
        } elseif ($current < $last && $isAsc) {
            return false;
        }
        $d = abs($current - $last);
        if ($d < 1 || $d > 3) {
            return false;
        }
        $last = $current;
    }
    return true;
}

function combinations(array $row): array {
    $results = [];
    $results[] = $row;
    for ($i = 0; $i < count($row); $i++) {
        $result = $row;
        unset($result[$i]);
        $results[] = $result;
    }
    return $results;
}

$res = 0;
while ($lv = array_shift($m)) {
    $toCheck = combinations($lv);
    while ($r = array_shift($toCheck)) {
        $safe = isSafe($r);
        if ($safe) {
            $res++;
            break;
        }
    }
}
echo "Result: $res / $total are safe.\n";
