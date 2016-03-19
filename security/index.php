<?php 
	
	require_once( 'Security.php' );

	$test = Security::getInstance();

	$test->startSession();
	$test->destroySession();

	$test::getLog()->write( 'hello', 'there'. 'there');
	
?>