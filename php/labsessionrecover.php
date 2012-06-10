<?php
ini_set('display_errors', 1); 
ini_set('log_errors', 1); 
error_reporting(E_ALL);


include ('Session.class.php');

Session::dumpSession('SESSION_TOKEN');
?>