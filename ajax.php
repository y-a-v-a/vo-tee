<?php
include 'conf.php';

if(IS_AJAX) {
	$amount = 2;
	if (isset($_GET['amount'])) {
		$amount = $_GET['amount'];
	}
	$coll = new Collection();
	$imgs = $coll->getAmountOf($amount);

	echo json_encode($imgs);
}

exit;