<?php

require_once __DIR__ . '/5_2_print.php';

$o = PrintQueue::test1();
$result = $o->run();
print_r("Result 1 is $result\n");

$o = PrintQueue::calc();
$result = $o->run();
print_r("Result is $result\n");
