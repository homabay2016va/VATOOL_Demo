<?php
session_start();
if(isset($_SESSION['sid'])){
	//remove all session variables
	session_unset(); 
	// destroy the session 
	session_destroy(); 
	
	header("location:../index.php");
}
?>