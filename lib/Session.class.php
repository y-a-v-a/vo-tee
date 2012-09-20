<?php

class Session {
	
	private static $session = null;
	
	private function __construct() {
		session_start();
	}
	
	public static function getSession() {
		if (self::$session === null) {
			self::$session = new Session();
		}
		return self::$session;
	}
	
	public function setValue($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	public function getValue($key) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		return null;
	}
	
	public function unsetValue($key) {
		unset($_SESSION[$key]);
	}
	
	static function valueExists($key) {
		return isset($_SESSION[$key]);
	}
}