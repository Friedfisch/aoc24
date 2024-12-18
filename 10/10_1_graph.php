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

    static public function run(M $map, int $x, int $y, int $parent, array &$result): void {
        $value = $map->value($x, $y);
        if ($parent === -1 && $value !== 0) {
            return;
        }
        if ($value === 9 && $parent === 8) {
            $result[] = "$x-$y";
            return;
        }
        if ($value === $parent + 1) {
            //echo "check x$x y$y v$value p$parent\n";
            G::run($map, $x, $y - 1, $value, $result);
            G::run($map, $x + 1, $y, $value, $result);
            G::run($map, $x, $y + 1, $value, $result);
            G::run($map, $x - 1, $y, $value, $result);
        }
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

//        print_r($this->map);
        /*        $graph = [];
          G::run($this->map, 3, 0, -1, $graph);
          $graph = array_unique($graph);
          print_r($graph);
          return count($graph);
          exit; */
        $cnt = 0;
        foreach ($this->map->map as $row => $cols) {
            foreach ($cols as $col => $v) {
                $graph = [];
                G::run($this->map, $col, $row, -1, $graph);
                $graph = array_unique($graph);
                $cnt += count($graph);
            }
        }
        return $cnt;
    }
}
