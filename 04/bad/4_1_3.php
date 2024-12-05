<?php

$search = 'XMAS';

$data = file('data4.txt');
$m = [];

/* $data = [
  "..X...",
  ".SAMX.",
  ".A..A.",
  "XMAS.S",
  ".X...."]; */

foreach ($data as $line) {
    if (!$line) {
        continue;
    }
    $m[] = str_split(trim($line));
}
/* $m2 = [
  ['X', 'X', 'A', 'S'],
  ['M', 'A', 'M', 'X'],
  ['A', 'M', 'A', 'S'],
  ['S', 'M', 'A', 'S'],
  ]; */

$result = 0;

function getRect(array $m, int $l, int $r, int $c): array {
    $w = $l;
    $rows = array_slice($m, $r, $l);
    $result = [];
    foreach ($rows as $row) {
        $r = array_slice($row, $c, $l);
        while (count($r) < $w) {
            $r[] = '-';
        }
        $result[] = $r;
    }
    while (count($result) < $w) {
        $result[] = array_fill(0, $w, '-');
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

function draw(array $m): void {
    echo "****\n";
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
        echo "---------------------------------------------------------------\n";
        echo "Found $data in $ln : \n";
        draw($row);
        echo "---------------------------------------------------------------\n";
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

function run(array $m, string $search): int {
    $lw = count($m[0]);
    $lh = count($m);
    $lz = strlen($search);
    $cnt = 0;
    draw($m);
    for ($h = 0; $h < $lh; $h++) {
        for ($w = 0; $w < $lw; $w++) {
            $rect = getRect($m, $lz, $h, $w, $lz);
            if ($rect[0][0] == $search[0]) {
                echo 'skip';
                continue;
            }
            draw($rect);
            $cnt += cntRect($rect, $lz, $search);
        }
    }
    return $cnt;
}

$cnt = run($m, $search);
echo "Result: $cnt.\n";
