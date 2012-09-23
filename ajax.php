<?php
include 'conf.php';

if(IS_AJAX) {
	$coll = new Collection();
	$imgs = $coll->getAmountOf(2);

	echo json_encode($imgs);
}

exit;