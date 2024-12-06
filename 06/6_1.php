<?php

require_once __DIR__ . '/6_1_guard.php';

$o = Guard::test1();
$result = $o->run();
print_r("Result 1 is $result\n");

$o = Guard::calc();
$result = $o->run();
print_r("Result is $result\n");
