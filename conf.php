<?php
error_reporting(E_ALL);
// TODO db connect info

if (!extension_loaded('imagick')) {
	echo "This app needs Imagick to be able to run properly.";
	die();
}

$path_parts = pathinfo(__FILE__);

define('VT_KICK_OFF', true);
define('DS', DIRECTORY_SEPARATOR);
define('VT_BASE', $path_parts['dirname']);
define('VT_UPLOADS', VT_BASE . DS . 'uploads');


function __autoload($classname) {
	$classPath = VT_BASE . DS . 'lib' . DS . $classname . '.class.php';
	if (file_exists($classPath)) {
		require_once $classPath;
	}
}

$sess = Session::getSession();
