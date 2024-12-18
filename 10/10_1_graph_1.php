<?php

class M {

    public array $map;
    protected int $height = 0;
    protected int $width = 0;

    public function __construct(array $map) {
        $this->map = $map;
        $this->height = count($this->map);
        $this->width = count($this->map[0]);
    }

    public function value(int $x, int $y): int {
        if ($x < 0 || $y < 0 || $x >= $this->width || $y >= $this->height) {
            return -1;
        }
        return $this->map[$y][$x];
    }
}

class G {

    static public function run(M $map, int $x, int $y, int $parent): int {
        $value = $map->value($x, $y);
        if ($parent === -1 && $value !== 0) {
            return 0;
        }
        echo "check x$x y$y v$value p$parent\n";
        if ($parent === 8 && $value === 9) {
            return 1;
        }
        $result = 0;
        $n = $map->value($x, $y - 1);
        if ($n > -1 && $n === $value + 1) {
            $result += G::run($map, $x, $y - 1, $value);
        }
        $e = $map->value($x + 1, $y);
        if ($e > -1 && $e === $value + 1) {
            $result += G::run($map, $x + 1, $y, $value);
        }
        $s = $map->value($x, $y + 1);
        if ($s > -1 && $s === $value + 1) {
            $result += G::run($map, $x, $y + 1, $value);
        }
        $w = $map->value($x - 1, $y);
        if ($w > -1 && $w === $value + 1) {
            $result += G::run($map, $x - 1, $y, $value);
        }
        return $result;
    }
}

class Graph {

    public ?int $expected = null;
    protected M $map;

    protected function __construct(?int $expected = null) {
        $this->expected = $expected;
    }

    protected function loadFromFile(string $fileName): void {
        $this->parseFileData(file($fileName));
    }

    protected function parseFileData(array $lines): void {
        $data = [];
        foreach ($lines as $line) {
            $tmp = str_split(trim($line));
            foreach ($tmp as &$v) {
                if ($v == '.') {
                    $v = -1;
                } else {
                    $v = (int) $v;
                }
            }
            $data[] = $tmp;
        }
        $this->setData($data);
    }

    protected function setData(array $map): void {
        $this->map = new M($map);
    }

    static public function test1(): Graph {

        /**
         * This larger example has 9 trailheads.
         * Considering the trailheads in reading order,
         * they have scores of 5, 6, 5, 3, 1, 3, 5, 3, and 5.
         * Adding these scores together, the sum of the scores of all trailheads is 36.
         */
        $o = new Graph(36);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): Graph {
        $o = new Graph(null);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run(): int {
        if (empty($this->map)) {
            return 0;
        }

        print_r($this->map);
        $graph = G::run($this->map, 3, 0, -1);
        //print_r($graph);
        return $graph;
        exit;
        $gs = [];
        foreach ($this->map->map as $row => $cols) {
            foreach ($cols as $col => $v) {
                $graph = G::run($this->map, $col, $row, -1);
//print_r($graph);
                $gs[] = $graph;
            }
        }
        print_r($gs);
        return 0;
    }
}
