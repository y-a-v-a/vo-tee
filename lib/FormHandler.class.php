<?php

class FormHandler {
	
	private static $instance = null;
	
	private function __construct() {}
	
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new FormHandler();
		}
		return self::$instance;
	}

	public function handle() {
		if (isset($_POST['key']) && strlen($_POST['key']) > 0 && $_POST['key'] === Session::getSession()->getValue('key')) {
			Session::getSession()->unsetValue('key');
			
			// handle form
			$processed = $this->processForm();
			if ($processed === true) {
				return true;
			}
		}
		return false;
	}

	public static function getKey() {
		Session::getSession()->unsetValue('key');
		$key = uniqid();
		Session::getSession()->setValue('key', $key);
		return $key;
	}
	
	private function processForm() {
		if ($this->isValid()) {
			// save stuff to dir and to db
			return true;
		}
		return false;
	}
	
	private function isValid() {
		$isValid = isset($_POST['design']) && strlen($_POST['design']) > 0
				&& isset($_POST['name']) && strlen($_POST['name']) > 0
				&& isset($_POST['url']) && strlen($_POST['url']) > 0
				&& isset($_POST['email']) && strlen($_POST['email']) > 0
				&& isset($_POST['hometown']) && strlen($_POST['hometown']) > 0;
		return $isValid;
	}
}