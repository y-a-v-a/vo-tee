<?php
include 'conf.php';

$res = false;

if (isset($_GET['design']) && IS_AJAX) {
	$db = VtDb::getInstance();
	
	$ip = $_SERVER['REMOTE_ADDR'];
	if ($db->hasReachedMax($ip)) {
		$res = array();
		$res['limit'] = true;
		echo json_encode($res);
		exit;
	}
	
	$design = $_GET['design'];
	

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