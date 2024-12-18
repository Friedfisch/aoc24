<?php

require_once __DIR__ . '/10_2_graph.php';

$o = Graph::test1();
$result = $o->run();
print_r("Result 1 is $result\n");
exit;
$o = Graph::calc();
$result = $o->run();
print_r("Result is $result\n");
