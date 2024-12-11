<?php

class Resonant {

    public ?int $expected = null;
    protected array $map;
    protected int $height = 0;
    protected int $width = 0;

    protected function __construct(?int $expected = null) {
        $this->expected = $expected;
    }

    protected function loadFromFile(string $fileName): void {
        $this->parseFileData(file($fileName));
    }

    protected function parseFileData(array $data): void {
        $map = [];
        while ($line = array_shift($data)) {
            if (trim($line) === '') {
                break;
            }
            $map[] = str_split(trim($line));
        }

        $this->setData($map);
    }

    protected function setData(array $map): void {
        $this->map = $map;
        $this->height = count($this->map);
        $this->width = count($this->map[0]);
    }

    static public function test1(): Resonant {

        $o = new Resonant(34);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): Resonant {
        $o = new Resonant(null);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function draw($data) {
        echo '****' . PHP_EOL;
        foreach ($data as $row) {
            foreach ($row as $char) {
                echo $char;
            }
            echo PHP_EOL;
        }
    }

    public function run(): int {
        $nodes = $this->map;
        $f = [];
        foreach ($this->map as $y => $row) {
            foreach ($row as $x => $char) {
                if ($char !== '.') {
                    if (!isset($f[$char])) {
                        $f[$char] = [];
                    }
                    $f[$char][] = [$x, $y];
                }
            }
        }

        foreach ($f as $char => $positions) {
            $nodes = $this->vecFromPos($positions, $nodes);
        }
        $this->draw($nodes);

        $result = 0;
        foreach ($nodes as $y => $row) {
            foreach ($row as $x => $char) {
                if ($char != '.') {
                    $result++;
                }
            }
        }

        return $result;
    }

    function vecFromPos(array $positions, $m) {
        while ($first = array_shift($positions)) {
            foreach ($positions as $pos) {
                for ($n = 1; $n < 1000; $n++) { // Infefficient, does not scale, does not work for very large grids
                    $dx1 = $first[0] + ($first[0] - $pos[0]) * $n;
                    $dy1 = $first[1] + ($first[1] - $pos[1]) * $n;
                    $dx2 = $pos[0] + ($pos[0] - $first[0]) * $n;
                    $dy2 = $pos[1] + ($pos[1] - $first[1]) * $n;
                    if ($dx1 >= 0 && $dx1 < $this->width &&
                            $dy1 >= 0 && $dy1 < $this->height) {
                        $m[$dy1][$dx1] = '#';
                    }
                    if ($dx2 >= 0 && $dx2 < $this->width &&
                            $dy2 >= 0 && $dy2 < $this->height) {
                        $m[$dy2][$dx2] = '#';
                    }
                }
            }
        }
        return $m;
    }
}
