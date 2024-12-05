<?php

enum CeresDirections {

    case WTE;
    case ETW;
    case NTS;
    case STN;
    case NWTSE;
    case NETSW;
    case SWTNE;
    case SETNW;

    public function dr(): int {
        return match ($this) {
            CeresDirections::WTE => 0,
            CeresDirections::ETW => 0,
            CeresDirections::NTS => 1,
            CeresDirections::STN => -1,
            CeresDirections::NWTSE => 1,
            CeresDirections::NETSW => 1,
            CeresDirections::SWTNE => -1,
            CeresDirections::SETNW => -1,
        };
    }

    public function dc(): int {
        return match ($this) {
            CeresDirections::WTE => 1,
            CeresDirections::ETW => -1,
            CeresDirections::NTS => 0,
            CeresDirections::STN => 0,
            CeresDirections::NWTSE => 1,
            CeresDirections::NETSW => -1,
            CeresDirections::SWTNE => 1,
            CeresDirections::SETNW => -1,
        };
    }
}

class Ceres {

    public ?int $expected = null;
    protected array $search;
    protected ?array $data = null;
    protected int $height = 0;
    protected int $width = 0;

    protected function __construct(string $search, ?int $expected = null) {
        $this->search = str_split($search);
        $this->expected = $expected;
    }

    protected function loadFromFile(string $fileName = 'data4.txt'): void {
        $this->parseFileData(file($fileName));
    }

    protected function parseFileData(array $data): void {
        $res = [];
        foreach ($data as $line) {
            if (!$line) {
                continue;
            }
            $res[] = str_split(trim($line));
        }
        $this->setData($res);
    }

    protected function setData(array $data): void {
        $this->data = $data;
        $this->height = count($this->data);
        $this->width = count($this->data[0]);
    }

    static public function test1(): Ceres {
        $search = 'XMAS';
        $data = [
            "..X...",
            ".SAMX.",
            ".A..A.",
            "XMAS.S",
            ".X...."];

        $ceres = new Ceres($search, 4);
        $ceres->parseFileData($data);
        return $ceres;
    }

    static public function test2(): Ceres {
        $search = 'XMAS';
        $m2 = [
            ['X', 'X', 'A', 'S'],
            ['M', 'A', 'M', 'X'],
            ['A', 'M', 'A', 'S'],
            ['S', 'M', 'A', 'S'],
        ];

        $ceres = new Ceres($search, 1);
        $ceres->setData($m2);
        return $ceres;
    }

    static public function test3(): Ceres {
        $search = 'XMAS';

        $ceres = new Ceres($search, 18);
        $ceres->loadFromFile(__DIR__ . '/data4_1.txt');
        return $ceres;
    }

    static public function calc(): Ceres {
        $search = 'XMAS';

        $ceres = new Ceres($search, 2468);
        $ceres->loadFromFile(__DIR__ . '/data4.txt');
        return $ceres;
    }

    public function draw(?array $data = null): void {
        if (is_null($data)) {
            if (is_null($this->data)) {
                echo "Nothing to draw";
                return;
            }
            $this->draw($this->data);
            return;
        }

        foreach ($data as $row) {
            if (is_array($row)) {
                foreach ($row as $col) {
                    echo $col;
                }
            } else {
                echo $row;
            }
            echo "\n";
        }
    }

    public function run(): int {
        $result = 0;
        for ($j = 0; $j < $this->height; $j++) {
            for ($i = 0; $i < $this->width; $i++) {
                foreach (CeresDirections::cases() as $case) {
                    $result += (int) $this->check($case, $j, $i);
                }
            }
        }
        return $result;
    }

    protected function check(CeresDirections $case, int $row, int $col): bool {
        $charIndex = 0;
        $c = '';

        while ($charIndex <= count($this->search)) {
            if ($row < 0 || $col < 0 || $row >= $this->height || $col >= $this->width) {
                return false;
            }
            echo "CHECK X:$col Y:$row I:$charIndex S:$c D:{$case->name}\n";
            $currentChar = $this->data[$row][$col];
            if ($currentChar !== $this->search[$charIndex]) {
                return false;
            }
            $c .= $currentChar;
            if (count($this->search) == $charIndex + 1) {
                echo "FOUND X:$col Y:$row I:$charIndex S:$c D:{$case->name}\n";
                return true;
            }
            $charIndex++;
            $row = $row + $case->dr();
            $col = $col + $case->dc();
        }
        return false;
    }
}
