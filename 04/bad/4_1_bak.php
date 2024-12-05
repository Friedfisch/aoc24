<?php

$data = file('data4.txt');
$m = [];
foreach ($data as $line) {
    $m[] = str_split(trim($line));
}

function flip_h(array $m): array {
    $r = [];
    foreach ($m as $x => $l) {
        foreach (array_reverse($l) as $y => $v) {
            $r[$x][] = $v;
        }
    }
    return $r;
}

function flip_v(array $m): array {
    $r = [];
    foreach (array_reverse($m) as $x => $l) {
        $r[] = $l;
    }
    return $r;
}

function draw(array $m): void {
    foreach ($m as $x => $l) {
        if (is_array($l)) {
            foreach ($l as $y => $v) {
                echo $v;
            }
        } else {
            echo $l;
        }
        echo "\n";
    }
}

function rot45(array $m): array {

}

function flatten(array $m): array {
    $r = [];
    foreach ($m as $x => $l) {
        $s = '';
        foreach ($l as $y => $v) {
            $s .= $v;
        }
        $r[] = $s;
    }
    return $r;
}

draw($m);
echo "**********************************\n";
draw(flip_h($m));
echo "**********************************\n";
draw(flip_v($m));
echo "**********************************\n";
draw(flip_v(flip_h($m)));
echo "**********************************\n";
draw(flatten($m));
exit;
$items = new items();
$d = file('data4.txt');
foreach ($d as $i => $line) {
    foreach (str_split(trim($line)) as $j => $w) {
        $items->add(new item($i, $j, strtoupper($w)));
    }
}

class item {

    public int $x;
    public int $y;
    public string $w;

    public function __construct(int $x, int $y, string $w) {
        $this->x = $x;
        $this->y = $y;
        $this->w = $w;
    }
}

class items {

    public array $data = [];
    private int $maxX = 0;
    private int $maxY = 0;

    public function add(item $i) {
        $this->data[] = $i;
        if ($i->x > $this->maxX) {
            $this->maxX = $i->x;
        }
        if ($i->y > $this->maxY) {
            $this->maxY = $i->y;
        }
    }

    public function at(int $x, int $y): string {
        $r = array_filter($this->data, function ($i) use ($x, $y) {
            return $i->x == $x && $i->y == $y;
        });
        if (!empty($r)) {
            return array_shift($r)->w;
        }
        return null;
    }

    function inBound(int $x, int $y): bool {
        return !($x < 0 || $y < 0 || $x > $this->maxX || $y > $this->maxY);
    }
}

$search = 'XMAS';
$result = 0;
$l = strlen($search);

print_r($items);
print_r($items->at(1, 1));
print_r($items->inBound(14, 1));

$scanData = [];
/** var item $i */
foreach ($items->data as $i) {
    if ($i->w !== 'X') {
        continue;
    }
    print_r($i);
    if ($items->inBound($i->x + 1, $i->y)) {
        print_r('e ');
    }
    if ($items->inBound($i->x - 1, $i->y)) {
        print_r('w ');
    }
    if ($items->inBound($i->x, $i->y + 1)) {
        print_r('n ');
    }
    if ($items->inBound($i->x, $i->y - 1)) {
        print_r('s ');
    }
    if ($items->inBound($i->x + 1, $i->y + 1)) {
        print_r('ne ');
    }
    if ($items->inBound($i->x - 1, $i->y + 1)) {
        print_r('nw ');
    }
    if ($items->inBound($i->x + 1, $i->y - 1)) {
        print_r('se ');
    }
    if ($items->inBound($i->x - 1, $i->y - 1)) {
        print_r('sw ');
    }
}

echo "Result: $result are safe.\n";
