<?php

enum Op: int {

    case Add = 1;
    case Mul = 2;

    public function eval(int $v1, ?int $v2): int {
        return match ($this) {
            Op::Add => $v1 + $v2,
            Op::Mul => is_null($v2) ? $v1 : $v1 * $v2,
            default => throw new Exception("asdfasdf"),
        };
    }
}

class Node {

    public int $v;
    public Op $op;
    public int $goal;
    public ?Node $mul = null;
    public ?Node $add = null;

    public function __construct(int $goal, int $v, Op $op) {
        $this->goal = $goal;
        $this->v = $v;
        $this->op = $op;
    }

    public function addNode(int $v): Node {
        if (is_null($this->add)) {
            $this->add = new Node($this->goal, $v, Op::Add);
            $this->mul = new Node($this->goal, $v, Op::Mul);
        } else {
            $this->add->addNode($v);
            $this->mul->addNode($v);
        }

        return $this;
    }
}

class Tree extends Node {

    public function __construct(int $goal, int $v) {
        $this->add = parent::__construct($goal, $v, Op::Add);
        $this->mul = parent::__construct($goal, $v, Op::Mul);
    }
}

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
            break;
        }
        return $result;
    }

    protected function traverse(Node $n, ?Node $p): int {
        if (is_null($n->add)) {
            $zz = $n->op->eval($n->v, null);
            echo "Last {$n->goal} '{$zz}' {$n->op->value}\n";
            return $zz;
        }
        if (!is_null($p)) {
            $v = $n->op->eval($n->v, $p->v);
            echo "Child {$n->goal} $v {$n->op->value}\n";
        } else {
            echo "Any\n";
            $v = $n->v;
        }
        $r1 = $this->traverse($n->add, $n);
        $r2 = $this->traverse($n->mul, $n);
        echo "r1 $r1 r2 $r2\n";
        return $r1 + $r2;
    }

    public function solve(int $goal, array $numbers): bool {
        $first = array_shift($numbers);
        $tree = new Tree($goal, $first);
        while ($no = array_shift($numbers)) {
            $tree->addNode($no);
        }
        print_r($tree);
        $match = $this->traverse($tree, null);
        print_r("**** $match ****\n");
        return $match;
    }
}
