<?php

require_once __DIR__ . '/11_1_pluto.php';

$o = Pluto::test1();
$result = $o->run(50);
print_r("Result 1 is $result\n");

$o = Pluto::calc();
$result = $o->run(25);
print_r("Result for 11.1 is $result\n");

$o = Pluto::calc();
//$result = $o->run(75);
print_r("Result for 11.2 is $result\n");
