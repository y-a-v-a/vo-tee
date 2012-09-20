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
	
}