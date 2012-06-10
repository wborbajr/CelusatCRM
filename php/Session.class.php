<?php

class Session {

	private static $instance;

	private function __construct() {}

	public static function createSession($sessionToken, $sessionObj, $sessionExpire) {
	
		if(!isset(self::$instance)){
			self::$instance = new Session();
			
			@session_cache_limiter('private');
			@session_cache_expire($sessionExpire);
			@session_start(void);
	
			$_SESSION[$sessionToken] = $sessionObj;
		}
	
		return self::$instance;
	}

	public function validateSession($sessionToken) {
		@session_start(void);
		return (isset($_SESSION[$sessionToken]);
		
	}
	
	public function dumpSession($sessionToken) {
		try {
			@session_start(void);
			var_dump($_SESSION[$sessionToken]);
		} catch (Exception $e) {
			die('Exception: ' . $e->getMessage());
		}
	}
	
	public function killSession() {
		@session_destroy(void);
		@session_unset(void);
		
		self::$instance = null;
	}
}

?>