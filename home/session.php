<?php
session_start();
if(!isset($_SESSION['sid'])){
	//remove all session variables
	session_unset(); 
	// destroy the session 
	session_destroy(); 
	#echo "not set";
	header("location:../index.php");
}else{
	//session_start();
	
	if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { 
		 session_unset(); 
		session_destroy(); 
    	header("location:../index.php"); //change yoursite.com to the name of you site!!
   

	} else{ 
	    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
	}

	$_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
	$_SESSION['expire_time'] = 30*60; //1800secs //expire time in seconds: three hours (you must change this)
}
?>