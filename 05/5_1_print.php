<?php

function pr(mixed $a, mixed $b = null): void {
    return;
    print_r($a);
    if (!is_null($b)) {
        echo ' => ';
        print_r($b);
    }
    echo PHP_EOL;
}

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
        $data = [
            "7|2\n",
            "2|4\n",
            "3|10\n",
            "4|10\n",
            "\n",
            "4,10,2\n", // 2,4,10 --> 4
            "2,1,10\n", // --> 2
            "4,10,3,1,2\n", // -->  1,2,4,3,20 ?? 1,2,3,4,10 ?? -->??
            "\n",
        ];

        $o = new PrintQueue(null);
        $o->parseFileData($data);
        return $o;
    }

    static public function test2(): PrintQueue {
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

        //pr($this->rules);
        /* $rules = [];
          foreach ($this->rules as $order) {
          list($before, $after) = $order;
          $before = (int) $before;
          $after = (int) $after;
          if (!isset($rules[$before])) {
          $rules[$before] = [];
          }
          $rules[$before][] = $after;
          }

          foreach ($rules as &$toSort) {
          sort($toSort, SORT_NUMERIC);
          }
          ksort($rules, SORT_NUMERIC); */
        //pr($this->jobs);

        $sorted = [];
        foreach ($this->jobs as $idx => $job) {
            $sorted[] = $this->processJob($idx, $job, $this->rules);
        }
        // Take middle number of each result and sum up

        return $result;
    }

    static public function moveAfter(array $arr, int $value, int $after): array {
        if ($value === $after) {
            return $arr;
        }
        $idxFrom = array_search($value, $arr);
        $idxTo = array_search($after, $arr);
        /* if ($idxFrom > $idxTo) {
          return $arr;
          } */
        $start = array_splice($arr, 0, $idxFrom);
        $middle = array_splice($arr, 1, $idxTo - $idxFrom);
        $end = array_splice($arr, 1);
        return array_merge($start, $middle, [$value], $end);
    }

    static public function moveBefore(array $arr, int $value, int $after): array {
        return array_reverse(self::moveAfter(array_reverse($arr), $value, $after));
    }

    public function processJob(int $idx, array $job, array $rules): array {

        // wenn update beide zahlen aus einem order enthält dann muss die erste irgendwann vor der zweiten kommen

        $floating = [];
        $keyRequiresValuesToBeBefore = [];
        $keyRequiresValuesToBeAfter = [];

        pr('rules', $rules);
        pr('job', $job);
        foreach ($job as $no) {

// THIS IS TRASH
            /* if (array_key_exists($no, $rules)) {
              foreach ($rules[$no] as $after) {
              if (in_array($after, $job)) {
              if (!isset($keyRequiresValuesToBeBefore[$after])) {
              $keyRequiresValuesToBeBefore[$after] = [];
              }
              $keyRequiresValuesToBeBefore[$after][] = $no;

              if (!isset($keyRequiresValuesToBeAfter[$no])) {
              $keyRequiresValuesToBeAfter[$no] = [];
              }
              $keyRequiresValuesToBeAfter[$no][] = $after;
              }
              }
              } else {
              $floating[] = $no;
              } */
        }

        $result = $job;
        pr('floating', $floating);

        pr("keyRequiresValuesToBeBefore", $keyRequiresValuesToBeBefore);
        foreach ($keyRequiresValuesToBeBefore as $key => $values) {
            foreach ($values as $value) {
                $result = self::moveBefore($result, $value, $key);
            }
        }
        pr('keyRequiresValuesToBeBeforeResult', $result);

        pr("keyRequiresValuesToBeAfter", $keyRequiresValuesToBeAfter);
        foreach ($keyRequiresValuesToBeAfter as $key => $values) {
            foreach ($values as $value) {
                $result = self::moveAfter($result, $value, $key);
            }
        }
        pr("keyRequiresValuesToBeAfterResult", $result);

        if ($result !== $job) {
            print_r("JOB $idx\n");
            print_r($job);

            print_r("RESULT $idx\n");
            print_r($result);
        } else {
            print_r("NOT CHANGED $idx\n");
        }

        return $result;
    }
}
