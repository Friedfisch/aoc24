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
            $j = explode('|', trim($line));
            array_walk($j, 'intval');
            $rules[] = $j;
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
        $o = new PrintQueue(123);
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
            if (!$this->processJob($job, $this->rules)) {
                $newJob = $this->reOrder($job, $this->rules);
                if (!$this->processJob($newJob, $this->rules)) {
                    throw new Exception('this is still wrong');
                }
                $result += $newJob[(count($newJob) - 1) / 2];
            }
        }

        return $result;
    }

    public function reOrder(array $job, array $rules): array {
        usort($job, function (int $a, int $b) use ($rules): int {
            foreach ($rules as $rule) {
                [$l, $r] = $rule;
                if ($l == $a && $r == $b) {
                    return -1;
                } elseif ($l == $b && $r == $a) {
                    return 1;
                }
            }
            return 0;
        });
        return $job;
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
