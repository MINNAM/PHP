<?php
/**
 * 
 * @author: Min Nam
 * 
 * General security implementation for Application Form.
 * 
**/
require_once( "Log.php" );

class Security{
	
	const SECURITY_PHRASE 		= "SOME RANDOM PHRASE"; // This could be changed daily and retrived from db to be more secure. Line 26
	const SUBMIT_LIMIT    		= 3;
	const SUBMIT_PENALTY  		= 500;
	const SUBMIT_PENALTY_LIMIT  = 86400000;
	
	private static $instance;
	private static $log;
	
	public static function getInstance() {

		if( self::$instance === null ) {

			self::$instance = new self();

		}

		return self::$instance;

	}

	protected function __construct() {

		self::$log = Log::getInstance();

	}

	private function __clone() {}
	private function __wakeup() {}


	private function getSecurityPhrase() {}

	public static function getLog() {

		return self::$log;

	}

	/**
	 * 
	 * Starts session and complicates possible Session Hijacking attempts.
	 * 
	 * ex.
	 * 
	 * Security::startSession(); // ON TOP OF A PHP CODE
	 * 
	**/
	public function startSession() {

		session_start();

		$part = "HTTP_USER_AGENT";

		if( isset( $_SESSION[ $part ] ) ) {

			if( hash_equals( $_SERVER[ $part ], self::generateToken( $part ) ) ) {

				self::$LOG->write( __METHOD__, "Original HTTP_USER_AGENT does not match with one from POST." );

			}else {

				// SAFE 
			}

		}else{
			
			$_SESSION[ $part ] = hash_hmac( "sha256", self::SECURITY_PHRASE , $_SERVER[ $part ] );

		}

		if( !isset( $_SESSION[ "submitAttempts" ] ) ) {

			$_SESSION[ "submitPenalty" ] = self::SUBMIT_PENALTY;
			$_SESSION[ "submitAttempts" ] = 0;

		}

		

	}

	public function destroySession() {

		$_SESSION = array();

		if ( ini_get( "session.use_cookies" ) ) {

    		$params = session_get_cookie_params();
    		setcookie( session_name(), '', time() - 42000, $params[ "path" ], $params[ "domain" ], $params[ "secure" ], $params[ "httponly" ] );

		}

		session_destroy();

	}

	/**
	 * 
	 * Cleans input data, prevents XSS attack
	 * 
	 * Delcaring ENT_NOQUOTES and "UTF-8" will pass accent characters.
	 * 
	 * ex. 
	 * 
	 * echo Security::sanitizeData( "\<h1>John Cage</h1>  " ) // John Cage
	 * 
	**/
	public function sanitizeData( $data, $encoding = "UTF-8" ) {

		$data = trim( $data );
		$data = stripslashes( $data );
		$data = htmlspecialchars( $data, ENT_QUOTES | ENT_HTML401, $encoding );	

		return $data;

	}

	/**
	 * 
	 * Cleans email input
	 * 
	**/
	public function sanitizeEmail( $email ) {

		return filter_var( $email, FILTER_SANITIZE_EMAIL );

	}

	/**
	 * 
	 * Validate Email, similar to regex 
	 * 
	 * ex.
	 *  
	 * Security::validateEmail( "design3@vec.ca" ) // true
	 * Security::validateEmail( "design3!vec.ca" ) // false
	 * 
	**/
	public function validateEmail( $email ) {

		return !filter_var( $email, FILTER_VALIDATE_EMAIL ) === false;

	}

	/**
	 * 
	 * Form Tokening, prevents CSRF Attack
	 * 
	 * ex.
	 * 
	 * <input type = 'hidden' name = 'userToken' value = <?php Security::generateToken() ?> />
	 * 
	 * AFTER POST
	 * 
	 * if( Security::validateToken( $POST[ "userToken" ] ) ) {
	 * 
	 * 		...
	 * 
	 * }
	 * 
	 * Security::resetToken();
	 * 
	**/
	public function generateToken( $part, $key = null ) {

		if( isset( $key ) ){

			return hash_hmac( "sha256", $key ,self::SECURITY_PHRASE );

		}

		$_SESSION[ $part ] = dechex( mt_rand() );


		return hash_hmac( "sha256", $_SESSION[ $part ] ,self::SECURITY_PHRASE );

	}

	public function validateToken( $part, $token ) {

		if( !isset( $_SESSION[ $part ] ) ) {

			self::$LOG->write( __METHOD__, "Session not set." );

			return false;

		}

		if( hash_equals( $token, self::generateToken( null, $_SESSION[ $part ] ) ) ) {

			return true;

		}else {
			
			self::$LOG->write( __METHOD__, "Session not set." );

			return false;

		}
		

	}

	public function resetToken( $part ) {

		unset( $_SESSION[ $part ] );

	}

	/**
	 * 
	 * Count number of submit per Session and return penalty time to prevent 
	 * resubmitting multiple times. DDoS
	 * 
	 * Need to change session to cookie
	 * 
	**/ 
	public function countSubmit() {

		$submitAttempts = $_SESSION[ "submitAttempts" ];

		if( $submitAttempts > self::SUBMIT_LIMIT ) {

			$_SESSION[ "submitPenalty" ] = min( $_SESSION[ "submitPenalty" ] * 2, self::SUBMIT_PENALTY_LIMIT );
			self::$LOG->write( __METHOD__, "Attempts on multiple submission." );

		}

		$_SESSION[ "submitAttempts" ]++;

		return $_SESSION[ "submitPenalty" ];

	}

}

?>