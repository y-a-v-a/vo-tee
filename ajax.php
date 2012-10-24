<?php
include 'conf.php';

if(IS_AJAX) {
	if (isset($_GET['amount'])) {
		$amount = $_GET['amount'];
	} else {
		$amount = 2;
	}
	$coll = new Collection();
	$imgs = $coll->getAmountOf($amount);

	echo json_encode($imgs);
}

exit;