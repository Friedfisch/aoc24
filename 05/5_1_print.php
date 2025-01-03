<?php

class PrintQueue {

    public ?int $expected = null;
    protected array $rules;
    protected array $jobs;

    protected function __construct(?int $expected = null) {
        $this->expected = $expected;
    }

    protected function loadFromFile(string $fileName): void {
        $this->parseFileData(file($fileName));
    }

    protected function parseFileData(array $data): void {
        $rules = [];
        while ($line = array_shift($data)) {
            if (trim($line) === '') {
                break;
            }
            $rules[] = explode('|', trim($line));
        }

        $jobs = [];
        while ($line = array_shift($data)) {
            if (trim($line) === '') {
                continue;
            }
            $j = explode(',', trim($line));
            array_walk($j, 'intval');
            $jobs[] = $j;
        }

        $this->setData($rules, $jobs);
    }

    protected function setData(array $rules, array $jobs): void {
        $this->rules = $rules;
        $this->jobs = $jobs;
    }

    static public function test1(): PrintQueue {
        /*
          75,47,61,53,29
          97,61,53,29,13
          75,29,13
         */
        $o = new PrintQueue(143);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): PrintQueue {
        $o = new PrintQueue(null);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run(): int {
        $result = 0;
        foreach ($this->jobs as $job) {
            if ($this->processJob($job, $this->rules)) {
                // Take middle number of each result and sum up
                $result += $job[(count($job) - 1) / 2];
            }
        }

        return $result;
    }

    public function processJob(array $job, array $rules): bool {
        foreach ($job as $idx => $no) {
            foreach ($rules as $rule) {
                [$b, $a] = $rule;
                if ($b !== $no) {
                    continue;
                }
                for ($i = 0; $i < $idx; $i++) {
                    if ($job[$i] === $a) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}
