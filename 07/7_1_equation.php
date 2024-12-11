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
        //3351424676480 ???? 
        $o = new Equation(null);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run(): int {
        $result = 0;
        foreach ($this->data as $target => $numbers) {
            $result += $this->solve($target, $numbers) ? $target : 0;
            //break;
        }
        return $result;
    }

    public function solve(int $goal, array $numbers): bool {
        $last = [array_shift($numbers)];
        while ($current = array_shift($numbers)) {
            $newLast = [];
            while ($prev = array_pop($last)) {
                $newLast[] = $prev + $current;
                $newLast[] = $prev * $current;
            }
            $last = $newLast;
        }

        print_r($last);
        $match = in_array($goal, $last);
        print_r("**** $goal is {$match} ****\n");
        return $match;
    }
}
