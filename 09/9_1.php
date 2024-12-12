<?php

require_once __DIR__ . '/9_1_fragmenter.php';

$o = Fragmenter::test0();
$result = $o->run();
print_r("Result 0 is $result\n");

$o = Fragmenter::test1();
$result = $o->run();
print_r("Result 1 is $result\n");

$o = Fragmenter::calc();
$result = $o->run();
print_r("Result is $result\n");
