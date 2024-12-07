<?php

class Equation {

    public ?int $expected = null;
    protected array $data;

    protected function __construct(?int $expected = null) {
        $this->expected = $expected;
    }

    protected function loadFromFile(string $fileName): void {
        $this->parseFileData(file($fileName));
    }

    protected function parseFileData(array $data): void {
        $res = [];
        while ($line = array_shift($data)) {
            [$key, $values] = explode(': ', $line);
            $values = explode(' ', $values);
            array_walk($values, 'intval');
            $res[(int) $key] = $values;
        }
        $this->setData($res);
    }

    protected function setData(array $data): void {
        $this->data = $data;
    }

    static public function test1(): Equation {

        $o = new Equation(3749);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): Equation {
        $o = new Equation(null);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run(): int {
        $result = 0;
        foreach ($this->data as $target => $numbers) {
            $result += $this->solve($target, $numbers) ? $target : 0;
        }
        return $result;
    }

    public function eval(array $numbers): array {
        //print_r($numbers);
        $no1 = array_shift($numbers);
        $no2 = array_shift($numbers);
        if (!is_null($no2)) {
            $a1 = $numbers;
            array_unshift($a1, $no1 + $no2);
            $c1 = $this->eval($a1);

            $a2 = $numbers;
            array_unshift($a2, $no1 * $no2);
            $c2 = $this->eval($a2);
        } else {
            $c1 = $no1;
            $c2 = $no1;
        }
        return [$c1, $c2];
    }

    public function solve(int $target, array $numbers): bool {
        $result = $this->eval($numbers);
//        echo "*******************\n";
        //print_r($result);
        //$flat = array_merge(...$result);
        $flat = [];
        array_walk_recursive($result, function ($item, $key) use (&$flat) {
            $flat[] = $item;
        });
        $flat = array_unique($flat);
        print_r($flat);
        $res = in_array($target, $flat) ? 'true' : 'false';
        echo "*** $target is $res ****************\n";
        return in_array($target, $flat);
    }
}
