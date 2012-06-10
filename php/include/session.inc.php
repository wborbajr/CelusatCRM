<?php
@session_start();

if(!isset($_SESSION["SESSION_TOKEN"])) {
	// redirect to login page
	header("Location: login.php");
	exit;
}
?>