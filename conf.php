<?php
error_reporting(E_ALL);

date_default_timezone_set("Europe/Amsterdam");

// define if request is AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	define('IS_AJAX', true);
} else {
	define('IS_AJAX', false);
}

// db connect info
define('DB_USER','root');
define('DB_PASSWD','');
define('DB_DB','votee');
define('DB_HOST','localhost');

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
