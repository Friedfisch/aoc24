<?php

require_once __DIR__ . '/9_2_fragmenter.php';

$o = Fragmenter::test1();
$result = $o->run();
print_r("Result 1 is $result\n");
exit;
$o = Fragmenter::calc();
$result = $o->run();
print_r("Result is $result\n");
