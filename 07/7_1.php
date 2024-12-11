<?php

require_once __DIR__ . '/7_1_equation.php';

$o = Equation::test1();
$result = $o->run();
print_r("Result 1 is $result\n");
//exit;
$o = Equation::calc();
$result = $o->run();
print_r("Result is $result\n");
