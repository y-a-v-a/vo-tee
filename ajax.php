<?php
include 'conf.php';

$coll = new Collection();
$imgs = $coll->getAmountOf(1);

echo json_encode($imgs);