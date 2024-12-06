<?php

enum Direction {

    case N;
    case E;
    case S;
    case W;

    public function turnRight(): Direction {
        return match ($this) {
            Direction::N => Direction::E,
            Direction::E => Direction::S,
            Direction::S => Direction::W,
            Direction::W => Direction::N,
        };
    }

    public function forward(int $x, int $y): array {
        return match ($this) {
            Direction::N => [$x, $y - 1],
            Direction::E => [$x + 1, $y],
            Direction::S => [$x, $y + 1],
            Direction::W => [$x - 1, $y],
        };
    }
}

class Guard {

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

    static public function test1(): Guard {

        $o = new Guard(41);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): Guard {
        $o = new Guard(null);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run(): int {
        $gx = $gy = 0;
        $dir = Direction::N;
        foreach ($this->map as $y => $row) {
            foreach ($row as $x => $char) {
                if ($char === '^') {
                    $gx = $x;
                    $gy = $y;
                    break(2); // ....
                }
            }
        }

        $path = [];
        while (true) {
            echo "Current: $gx $gy\n";
            [$tx, $ty] = $dir->forward($gx, $gy);
            echo "Test: $tx $ty Bounds 0 0 {$this->width} {$this->height}\n";
            if ($tx < 0 || $ty < 0 || $tx > $this->width || $ty > $this->height) {
                echo "OOB\n";
                break;
            }
            switch ($this->map[$ty][$tx]) {
                case '#':
                    echo "Turn\n";
                    $dir = $dir->turnRight($gx, $gy);
                    break;

                default:
                    echo "Move\n";
                    [$gx, $gy] = $dir->forward($gx, $gy);
                    $u = "$gx $gy";
                    if (!array_key_exists($u, $path)) {
                        $path[$u] = 0;
                    }
                    $path[$u]++;
            }
        }
        return count($path);
    }
}
