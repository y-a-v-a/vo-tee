<?php
include 'conf.php';

$res = false;

if (isset($_GET['design']) && IS_AJAX) {
	$ip = $_SERVER['REMOTE_ADDR'];

	$design = $_GET['design'];
	
	$db = VtDb::getInstance();
	if (!$db->isGood($design)) {
		Vtlog::log($design . ' is voted for but is not good!');
		echo json_encode($res);
		exit;
	}
	if ($db->hasVoted($ip, $design) > 1) {
		Vtlog::log($ip . ' has voted already!');
		echo json_encode($res);
		exit;
	}

	$isAdded = $db->addVote($ip, $design);
	if ($isAdded === true) {
		$res['votecount'] = $db->getVoteCountFor($design);
		$res['agentVoted'] = '1';
		$res['id'] = $_GET['design'];
	}
	
}
echo json_encode($res);

exit;