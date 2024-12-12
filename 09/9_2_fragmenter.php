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
        $o = new Fragmenter(null); // too low: 85452072118
        $o->loadFromFile(__DIR__ . '/input.txt');
        return $o;
    }

    public function run(): int {
        if (empty($this->data)) {
            return 0;
        }

        $extended = [];
        $no = -1;
        foreach ($this->data as $idx => $cnt) {
            if ($idx % 2 == 0) {
                $no++;
                $extended[] = [$no, $cnt];
            } else {
                $extended[] = ['.', $cnt];
            }
        }

        while ($no > 0) {
            $this->draw($extended);
            $extended = $this->process($extended, $no);
            $no--;
            //break;
        }

        $result = 0;
        $no = -1;
        foreach ($this->draw($extended) as $idx => $p) {
            if ($idx % 2 == 0) {
                $no++;
            }
            //echo "$idx ** $p " . PHP_EOL;
            if ($p === '.') {
                continue;
            }
            $result += $idx * $p;
        }
        return $result;
    }

    function draw(array $d): array {
        $s = '';
        foreach ($d as $p) {
            for ($i = 0; $i < $p[1]; $i++) {
                $s .= $p[0];
            }
        }
        echo $s . PHP_EOL;
        return str_split($s);
    }

    private function freeSlot(array $extended, int $maxIdx, int $size): ?array {
        for ($i = 0; $i < $maxIdx; $i++) {
            if ($extended[$i][0] === '.' && $extended[$i][1] >= $size) {
                print_r('FREE ' . implode(';', [$i, $extended[$i][1]]) . " REQ $size" . PHP_EOL);
                return [$i, $extended[$i][1]];
            }
        }

        return null;
    }

    private function process(array $extended, int $search): array {
        $searchItem = null;
        for ($i = count($extended) - 1; $i > 0; $i--) {
            if ($extended[$i][0] === $search) {
                $searchItem = [$i, $extended[$i][0], $extended[$i][1]];
                break;
            }
        }
        if (is_null($searchItem)) {
            return $extended;
        }
        [$from, $c, $size] = $searchItem;
        [$free, $slotSize] = $this->freeSlot($extended, $i, $size);
        print_r('DATA ' . implode(';', $searchItem) . " FREE: $free" . PHP_EOL);
        if (!is_null($free)) {
            //for ($idx = 0; $idx <= $size; $idx++) {
            echo "* $search ***** $from ******* $free *********************" . PHP_EOL;
            //$this->draw($extended);
            $extended[$from] = ['.', $size];
            //$this->draw($extended);
            $extended[$free] = [$c, $size];
            //$this->draw($extended);
            //echo "asdfa sdfas df" . PHP_EOL;
            if ($size < $slotSize) {
                $empty = ['.', $slotSize - $size];
                $head = array_slice($extended, 0, $free + 1);
                $remains = array_slice($extended, $free + 1);
                $extended = $head;
                $extended[] = $empty;
                foreach ($remains as $d) {
                    $extended[] = $d;
                }
                // Insert remaining free slots
            }
            $this->draw($extended);
        }

        return $extended;
    }
}
