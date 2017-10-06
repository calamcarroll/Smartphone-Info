<?php

	session_start();
	
	require_once 'class.user.php';
	

	$session = new USER();
	
	//redirects user to home page 
	// This file is included in pages that can only be accessed when the user is logged in 

	if(!$session->is_loggedin())
	{
		// session not set redirects to home page
		$session->redirect('home.php');
	}

	
	?>