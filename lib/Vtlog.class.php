<?php
class Vtlog {
	public static function log($msg) {
		$logFile = VT_BASE . DS . 'data' . DS . 'system.log';
		$now = date("Y-m-d H:i:s");
		if (!file_exists($logFile)) {
			return;
		}
		$logLine = $now . ' ';
		if (is_array($msg)) {
			$logLine .= implode(' ', $msg);
		} elseif (is_object($msg)) {
			$logLine .= serialize($msg);
		} else {
			$logLine .= $msg;
		}
		$logLine .= "\n";
		
		return @file_put_contents($logFile, $logLine, FILE_APPEND);
	}
}