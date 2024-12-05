<?php

class Ceres {

    public ?int $expected = null;
    protected array $search;
    protected ?array $data = null;
    protected int $height = 0;
    protected int $width = 0;

    protected function __construct(array $search, ?int $expected = null) {
        $this->search = $search;
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
        $search = [];
        $search[] = [
            ['M', null, 'M'],
            [null, 'A', null],
            ['S', null, 'S']
        ];
        $search[] = [
            ['M', null, 'S'],
            [null, 'A', null],
            ['M', null, 'S']
        ];
        $search[] = [
            ['S', null, 'M'],
            [null, 'A', null],
            ['S', null, 'M']
        ];
        $search[] = [
            ['S', null, 'S'],
            [null, 'A', null],
            ['M', null, 'M']
        ];

        $ceres = new Ceres($search, 9);
        $ceres->loadFromFile(__DIR__ . '/data4_1.txt');
        return $ceres;
    }

    static public function calc(): Ceres {
        $search = [];
        $search[] = [
            ['M', null, 'M'],
            [null, 'A', null],
            ['S', null, 'S']
        ];
        $search[] = [
            ['M', null, 'S'],
            [null, 'A', null],
            ['M', null, 'S']
        ];
        $search[] = [
            ['S', null, 'M'],
            [null, 'A', null],
            ['S', null, 'M']
        ];
        $search[] = [
            ['S', null, 'S'],
            [null, 'A', null],
            ['M', null, 'M']
        ];

        $ceres = new Ceres($search, null);
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
        $pr = count($this->search[0]);
        $pc = count($this->search[0][0]);
        for ($j = 0; $j < $this->height - $pr + 1; $j++) {
            for ($i = 0; $i < $this->width - $pc + 1; $i++) {
                $result += (int) $this->check($j, $i);
            }
        }
        return $result;
    }

    protected function check(int $row, int $col): bool {
        $cmp = [];
        $pr = count($this->search[0]);
        $pc = count($this->search[0][0]);
        for ($r = 0; $r < $pr; $r++) {
            $line = [];
            for ($c = 0; $c < $pc; $c++) {
                $line[] = is_null($this->search[0][$r][$c]) ? null : $this->data[$r + $row][$c + $col];
            }
            $cmp[] = $line;
        }
        foreach ($this->search as $search) {
            if ($cmp === $search) {
                return true;
            }
        }
        return false;
    }
}
