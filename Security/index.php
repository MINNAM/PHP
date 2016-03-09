<?php 
	
	//startSession();
	

	require_once( "Security.php" );

	Security::startSession();

	Security::countSubmit();

	$log = new Log();

	$log->toHTMLTable();


?>