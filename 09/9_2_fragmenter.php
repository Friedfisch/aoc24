<?php

class Fragmenter {

    public ?int $expected = null;
    protected array $data;

    protected function __construct(?int $expected = null) {
        $this->expected = $expected;
    }

    protected function loadFromFile(string $fileName): void {
        $this->parseFileData(file($fileName));
    }

    protected function parseFileData(array $lines): void {
        $data = str_split(trim(array_shift($lines)));
        $this->setData($data);
    }

    protected function setData(array $map): void {
        $this->data = $map;
    }

    static public function test1(): Fragmenter {

        $o = new Fragmenter(2858);
        $o->loadFromFile(__DIR__ . '/test.txt');
        return $o;
    }

    static public function calc(): Fragmenter {
        $o = new Fragmenter(null);
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run(): int {
        if (empty($this->data)) {
            return 0;
        }
        return 0;
        /* $extended = [];
          $free = '.';
          $no = 0;
          foreach ($this->data as $idx => $in) {
          if ($idx % 2 == 0) {
          for ($i = 0; $i < $in; $i++) {
          $extended[] = $no;
          }
          $no++;
          } else {
          for ($i = 0; $i < $in; $i++) {
          $extended[] = $free;
          }
          }
          }


          $firstFree = null;
          while (true) {
          //print_r(implode($extended) . PHP_EOL);
          $nf = $this->nextFree($free, $extended, $firstFree);
          $lastUsed = $this->lastUsed($free, $extended, $nf);
          if (!$lastUsed) {
          break;
          }
          $extended[$nf] = $extended[$lastUsed];
          $extended[$lastUsed] = $free;
          }

          $result = 0;
          foreach ($extended as $idx => $no) {
          if ($no === $free) {
          break;
          }
          $result += $idx * $no;
          }
          return $result; */
    }

    /* private function nextFree(string $free, array $extended, ?int $firstFree): int {

      for ($i = $firstFree ?: 0; $i < count($extended) - 1; $i++) {
      if ($extended[$i] === $free) {
      return $i;
      }
      }
      print_r(implode(' ', $extended) . PHP_EOL);
      throw new Exception('no free blocks');
      }

      private function lastUsed(string $free, array $extended, int $nextFree): ?int {
      for ($i = count($extended) - 1; $i > $nextFree; $i--) {
      if ($extended[$i] !== $free) {
      return $i;
      }
      }
      return null;
      } */
}
