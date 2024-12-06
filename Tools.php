<?php

abstract class Tools {

    static public function moveAfter(array $arr, int $value, int $after): array {
        if ($value === $after) {
            throw new Exception('asdfasdfasd');
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

    static public function pr(mixed $a, mixed $b = null): void {
        print_r($a);
        if (!is_null($b)) {
            echo ' => ';
            print_r($b);
        }
        echo PHP_EOL;
    }
}
