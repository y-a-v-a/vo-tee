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
		$i = 0;
		$wanted = array();
		
		foreach ($images as $image) {
			if (!in_array($image, $this->loaded)) {
				$i++;
				$this->loaded[] = $image;
				$wanted[] = strstr($image, 'uploads');
				if ($i == $amount) {
					break;
				}
			}
		}
		Session::getSession()->setValue('loaded', serialize($this->loaded));
		return $wanted;
	}
	
}