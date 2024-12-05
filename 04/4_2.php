<?php

require_once __DIR__ . '/4_2_ceres.php';

$ceres = Ceres::test1();
$ceres->draw();
$result = $ceres->run();
print_r("Result 1 is $result\n");

$ceres = Ceres::calc();
//$ceres->draw();
$result = $ceres->run();
print_r("Result is $result\n");

