<?php

class Pluto {

    public ?int $expected = null;
    protected array $map;

    protected function __construct(?int $expected = null) {
        $this->expected = $expected;
    }

    protected function loadFromFile(string $fileName): void {
        $this->parseFileData(file($fileName));
    }

    protected function parseFileData(array $lines): void {
        $split = $this->setData(explode(' ', trim($lines[0])));
    }

    protected function setData(array $map): void {
        $this->map = $map;
    }

    static public function test1(): self {
        $o = new self(null);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): self {
        $o = new self(189092);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run($blinks): int {
        if (empty($this->map)) {
            return 0;
        }
        $r = 0;
        echo count($this->map) . " to process \n";
        foreach ($this->map as $idx => $stone) {
            $r += $this->processStone($stone, $blinks);
            echo "$idx $r\n";
        }
        return $r;

        // 1 2024 1 0 9 9 2021976.
    }

    private function processStone($stone, $blinks): int {
        //echo "$stone $blinks\n";
        if ($blinks == 0) {
            return 1;
        }

        $tmp = [];
        if ($stone == 0) {
            $tmp[] = 1;
        } else {
            $digits = strlen($stone);
            if ($digits % 2 == 0) {
                $tmp[] = 0 + substr($stone, 0, $digits / 2);
                $tmp[] = 0 + substr($stone, $digits / 2);
            } else {
                $tmp[] = $stone * 2024;
            }
        }
        $res = 0;
        foreach ($tmp as $v) {
            $res += $this->processStone($v, $blinks - 1);
        }
        return $res;
    }
}
