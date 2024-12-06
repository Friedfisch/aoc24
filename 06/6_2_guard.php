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

        $o = new Guard(6);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): Guard {
        $o = new Guard(1705);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    protected function move(array $map, array $walk): ?array {
        [$gx, $gy, $dir] = $walk;
        [$tx, $ty] = $dir->forward($gx, $gy);
        if ($tx === -1 || $ty === -1 || $tx === $this->width || $ty === $this->height) {
            return null;
        }
        if ($map[$ty][$tx] === '#') {
            $dir = $dir->turnRight($gx, $gy);
        } else {
            [$gx, $gy] = [$tx, $ty];
        }
        return [$gx, $gy, $dir];
    }

    protected function hasLoop(array $map, array $walk): bool {
        $path = [];
        while (true) {
            $path[] = $walk;
            $walk = $this->move($map, $walk);
            if (is_null($walk)) {
                return false;
            }
            if (in_array($walk, $path)) {
                return true;
            }
        }
    }

    public function run(): int {
        $map = $this->map;
        $walk = null;
        foreach ($map as $y => $row) {
            foreach ($row as $x => $char) {
                if ($char === '^') {
                    $walk = [$x, $y, Direction::N];
                    break(2); // ....
                }
            }
        }
        if (!$walk) {
            throw new Exception('no starting position');
        }

        /**
         *
         * über uns muss ein blocker sein. wenn keiner da ist dann muss dort einer gesetzt werden
         * ist lane frei -> ende
         *
         */
        $result = 0;
        $max = $this->height * $this->width;
        $current = 0;
        for ($oy = 0; $oy < $this->height; $oy++) {
            for ($ox = 0; $ox < $this->width; $ox++) {
                $current++;
                if ($walk == [$ox, $oy, $walk[2]]) {
                    // Start position skip
                    continue;
                }
                $map = $this->map;
                if ($map[$oy][$ox] === '#') {
                    // There is already a tile
                    continue;
                }
                $map[$oy][$ox] = '#';
                $res = (int) $this->hasLoop($map, $walk);
                $result += $res;

                echo "$current / $max ($ox,$oy) -> $res Total: $result\n";
            }
        }
        return $result;
    }
}
