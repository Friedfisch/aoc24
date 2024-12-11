<?php

require_once __DIR__ . '/8_2_resonant.php';

$o = Resonant::test1();
$result = $o->run();
print_r("Result 1 is $result\n");
//exit;
$o = Resonant::calc();
$result = $o->run();
print_r("Result is $result\n");
