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

    public function run($totalBlinks): int {
        if (empty($this->map)) {
            return 0;
        }
        $stones = $this->map;
        $blinks = $totalBlinks;
        while ($blinks > 0) {
            print_r("$blinks ");
            $tmp = [];
            //print_r("#$blinks:\t" . implode(' ', $stones) . PHP_EOL);
            foreach ($stones as $stone) {
                if ($stone == 0) {
                    $tmp[] = 1;
                    continue;
                }

                $digits = strlen($stone);
                if ($digits % 2 == 0) {
                    $tmp[] = 0 + substr($stone, 0, $digits / 2);
                    $tmp[] = 0 + substr($stone, $digits / 2);
                    continue;
                }

                $tmp[] = $stone * 2024;
            }
            $stones = $tmp;
            $blinks--;
        }
        // 1 2024 1 0 9 9 2021976.
        //print_r("#$blinks:\t" . implode(' ', $stones) . PHP_EOL);

        return count($stones);
    }
}
