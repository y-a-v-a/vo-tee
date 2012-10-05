<?php

class Collection {
	
	private $loaded = array();
	
	public function __construct() {
		if (!Session::getSession()->valueExists('loaded')) {
			Session::getSession()->setValue('loaded', serialize(array()));
		}
		$this->loaded = unserialize(Session::getSession()->getValue('loaded'));
	}
	
	public function getAmountOf($amount) {
		$images = glob(VT_UPLOADS . DS . '*' . DS . '*.jpg');
		shuffle($images);
		$i = 0;
		$wanted = array();
		
		foreach ($images as $image) {
			if (!in_array($image, $this->loaded)) {
				$i++;
				$this->loaded[] = $image;
				
				$wanted[] = $this->getImageData($image);
				if ($i == $amount) {
					break;
				}
			}
		}
		Session::getSession()->setValue('loaded', serialize($this->loaded));
		return $wanted;
	}
	
	private function getImageData($imagePath) {
		$data = array();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$info = pathinfo($imagePath);
		$doesMatch = preg_match('/U[0-9]{9,10}/',$info['dirname'], $m);
		if ($doesMatch == 0) {
			Vtlog::log('The image ' . $image . ' does not match the regexp in ' . __CLASS__ . ' ' . __LINE__);
		}
		$id = $m[0];
		$data['votecount'] = VtDb::getInstance()->getVoteCountFor($id);
		$data['agentVoted'] = VtDb::getInstance()->hasVoted($ip, $id);
		$data['id'] = $id;
		$data['createdBy'] = VtDb::getInstance()->getApplicantInfo($id);
		
		$data['htpath'] = strstr($imagePath, 'uploads');
		return $data;
	}
	
}