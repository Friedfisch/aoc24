<?php

require_once __DIR__ . '/5_1_print.php';

/* print_r(PrintQueue::moveAfter(explode(',', '1,2,3,4,5,6,7,8,9,10,11,12,13,14'), 4, 12));
  print_r(PrintQueue::moveBefore(explode(',', '1,2,3,4,5,6,7,8,9,10,11,12,13,14'), 12, 4));
  exit; */

$o = PrintQueue::test2();
$result = $o->run();
print_r("Result 1 is $result\n");

exit;

$o = PrintQueue::test2();
$result = $o->run();
print_r("Result 2 is $result\n");

exit;

$o = PrintQueue::calc();
$result = $o->run();
print_r("Result is $result\n");
