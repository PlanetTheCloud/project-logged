<?php

# Check if file was accessed directly
if(!defined('APP')){
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * CSRF Class (Simplified)
 * This class is taken from Project LOGGED 1.7
 * Simplified to suit the need for 1.6r.
 */
class Csrf
{

	# Defines how many bits to use
	private $bit = 128;
	# Current timestamp when the class is instantiated
	private $time = 9999999999;
	
	# Initializes CSRF
	function __construct(){
		$this->checkSession();
		$this->time = time();
		$this->deleteExpiredTokens();
	}

	# Check if session exsist
	private function checkSession(){
		if(!isset($_SESSION['csrf_token'])){
			$_SESSION['csrf_token'] = [];
		}
	}

	# Generate random token
	private function generateToken(){
		return bin2hex(openssl_random_pseudo_bytes($this->bit));
	}

	# Set Token
	private function setToken(String $name, Int $expires=10800){
		$_SESSION['csrf_token'][$name] = [
			'token' => $this->generateToken(),
			'expire' => $expires + $this->time
		];
	}

	# Create CSRF token
	public function createToken(String $name, Int $expires=10800){
		$this->checkSession();
		if(!isset($_SESSION['csrf_token'][$name])){
			$this->setToken($name, $expires);
		}
		return $_SESSION['csrf_token'][$name];
	}

	# Renew CSRF Token
	public function renewToken(String $name, Int $expires=10800){
		$this->checkSession();
		$this->setToken($name, $expires);
		return $_SESSION['csrf_token'][$name];
	}

	# Verify CSRF Token
	public function verifyToken(String $name, String $token){
		$this->checkSession();
		if(isset($_SESSION['csrf_token'][$name])){
			if(hash_equals($_SESSION['csrf_token'][$name]['token'], $token)){
				return true;
			}
		}
		return false;
	}

	# Check if token is expired
	public function isExpired(String $name){
		if($this->time > $_SESSION['csrf_token'][$name]['expire']){
			return true;
		}
		return false;
	}

	# Delete token
	public function delete(String $name){
		$this->checkSession();
		if(isset($_SESSION['csrf_token'][$name])){
			unset($_SESSION['csrf_token'][$name]);
		}
	}

	# Delete Expired tokens
	public function deleteExpiredTokens(){
		$this->checkSession();
		$deleted = [];
		foreach ($_SESSION['csrf_token'] as $key => $value) {
			if($this->isExpired($key)){
				$this->delete($key);
				$deleted[] = $key;
			}
		}
		return $deleted;
	}

	# Get token
	public function getToken(String $name){
		$this->checkSession();
		return $_SESSION['csrf_token'][$name]['token'];
	}
}