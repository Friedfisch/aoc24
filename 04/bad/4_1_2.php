<?php

$search = 'XMAS';

$data = file('data4.txt');
$m = [];
foreach ($data as $line) {
    $m[] = str_split(trim($line));
}
$m2 = [
    ['X', 'X', 'A', 'S'],
    ['M', 'A', 'M', 'X'],
    ['A', 'M', 'A', 'S'],
    ['S', 'M', 'A', 'S'],
];

$result = 0;

function getRect(array $m, int $l, int $j, int $i): array {
    $rows = array_slice($m, $j, $l);
    $result = [];
    foreach ($rows as $row) {
        $result[] = array_slice($row, $i, $l);
    }
    return $result;
}

function getCol(array $r, int $l, int $c): array {
    $res = [];
    for ($i = 0; $i < $l; $i++) {
        $res[] = $r[$i][$c];
    }
    return $res;
}

function getDiag(array $r, int $l, $dir): array {
    $res = [];
    switch ($dir) {
        case 0:
            for ($i = 0; $i < $l; $i++) {
                $res[$i] = $r[$i][$i];
            }
            break;
        case 1:
            for ($i = 0; $i < $l; $i++) {
                $res[$i] = $r[$i][$l - 1 - $i];
            }
            break;
        case 2:
            for ($i = 0; $i < $l; $i++) {
                $res[$i] = $r[$l - 1 - $i][$i];
            }
            break;
        case 3:
            for ($i = 0; $i < $l; $i++) {
                $res[$i] = $r[$l - 1 - $i][$l - 1 - $i];
            }
            break;
        default:
            throw new Exception('unknown dir');
    }
    return $res;
}

function draw2(array $m): void {
    foreach ($m as $l) {
        if (is_array($l)) {
            foreach ($l as $v) {
                echo $v;
            }
        } else {
            echo $l;
        }
        echo "\n";
    }
}

function cnt(array $data, string $s, array $row, int $ln): int {
    $data = implode('', $data);
    if ($s == $data) {
        echo "Found $data in $ln\n";
        draw2($row);
        return 1;
    }
    return 0;
}

function cntRect(array $r, int $l, string $s) {
    $cnt = 0;
    for ($i = 0; $i < $l; $i++) {
        $cnt += cnt($r[$i], $s, $r, __LINE__);
        $cnt += cnt(array_reverse($r[$i]), $s, $r, __LINE__);
        $cnt += cnt(getCol($r, $l, $i), $s, $r, __LINE__);
        $cnt += cnt(array_reverse(getCol($r, $l, $i)), $s, $r, __LINE__);

        $cnt += cnt(getDiag($r, $l, 0), $s, $r, __LINE__);
        $cnt += cnt(getDiag($r, $l, 1), $s, $r, __LINE__);
        $cnt += cnt(getDiag($r, $l, 2), $s, $r, __LINE__);
        $cnt += cnt(getDiag($r, $l, 3), $s, $r, __LINE__);
    }
    return $cnt;
}

$lx = count($m[0]);
$ly = count($m);
$lz = strlen($search);
$cnt = 0;
for ($j = 0; $j <= $ly - $lz; $j++) {
    for ($i = 0; $i <= $lx - $lz; $i++) {
        $rect = getRect($m, $lz, $j, $i, $lz);
        print_r($rect);
        $cnt += cntRect($rect, $lz, $search);
    }
}

echo "Result: $cnt.\n";

exit;

function rot90(array $m): array {
    $r = [];
    foreach ($m as $x => $l) {
        foreach ($l as $y => $v) {
            $r[$y][$x] = $v;
        }
    }
    return $r;
}

function flip_v(array $m): array {
    $r = [];
    foreach (array_reverse($m) as $l) {
        $r[] = $l;
    }
    return $r;
}

function flip_h(array $m): array {
    $r = [];
    foreach ($m as $i => $l) {
        foreach (array_reverse($l) as $v) {
            $r[$i][] = $v;
        }
    }
    return $r;
}

function draw(array $m): void {
    foreach ($m as $l) {
        if (is_array($l)) {
            foreach ($l as $v) {
                echo $v;
            }
        } else {
            echo $l;
        }
        echo "\n";
    }
}

/*
  function rot45(array $m): array {
  $r = [];
  for ($j = 0; $j < count($m[0]); ++$j) {
  for ($i = 0; $i < count($m); ++$i) {
  $r[$i + $j][] = $m[$i][$j];
  }
  }
  draw($r);
  return $r;
  } */

function countS(string $search, string $subject): int {
    $matches = [];
    preg_match_all("/$search/", $subject, $matches, PREG_SET_ORDER);
    print_r($subject . PHP_EOL);
    print_r($matches);
    return count($matches);
}

function countM(string $search, array $subjects): int {
    $r = 0;
    foreach ($subjects as $subject) {
        $r += countS($search, implode('', $subject));
    }
    return $r;
}

function countMD(string $search, array $ms): int {
    $r = 0;
    $d1 = $d2 = $d3 = $d4 = [];
    $l = count($ms) - 1;
    for ($i = 0; $i <= $l; $i++) {
        $d1[$i][] = $ms[$i][$i];
        $d2[$i][] = $ms[$l - $i][$i];
        $d3[$i][] = $ms[$i][$l - $i];
        $d4[$i][] = $ms[$l - $i][$l - $i];

        break;
    }
    print_r("d1 " . implode(' ', $d1) . PHP_EOL);
    print_r("d2 " . implode(' ', $d2) . PHP_EOL);
    print_r("d3 " . implode(' ', $d3) . PHP_EOL);
    print_r("d4 " . implode(' ', $d4) . PHP_EOL);

    print_r($ms);
//$r += countS($search, implode('', $subject));
    return $r;
}

/* echo "l to r " . countM($search, $m) . "\n";
  echo "r to l " . countM($search, flip_h($m)) . "\n";
  echo "u to d " . countM($search, rot90($m)) . "\n";
  echo "d to u " . countM($search, flip_h(rot90($m))) . "\n";

 */
echo "ur->br " . countMD($search, $m) . "\n";

//draw($m);
exit;
$matrix = [
    $m, // left: 3
    flip_h($m), // right: 2
    rot90($m), // down: 1
    flip_h(rot90($m)), // up: 2
//ltr d:1 u:3
        /* rot45($m),
          rot45(rot90($m)),
          rot45(flip_v($m)),
          rot45(flip_v(rot90($m))), */
];
print_r($matrix);
exit;
//$matrix = array_unique($matrix);
print_r($matrix);
//print_r($matrix);
$result = 0;
foreach ($matrix as $idx => $subject) {
    $result += countS($search, $subject);
}

echo "Result: $result.\n";
