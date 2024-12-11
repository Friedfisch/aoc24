<?php

require_once __DIR__ . '/8_1_resonant.php';

$o = Resonant::test1();
$result = $o->run();
print_r("Result 1 is $result\n");

$o = Resonant::calc();
$result = $o->run();
print_r("Result is $result\n");
