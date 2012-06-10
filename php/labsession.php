<?php
//ini_set('display_errors', 1); 
//ini_set('log_errors', 1); 
//error_reporting(E_ALL);

@include ('Session.class.php');

//$session = new Session('SESSION_TOKEN');

$sessionData = array();
$sessionData['user'] = 'borba_v2';
$sessionData['time'] = '09:21';
$sessionData['date'] = '14/06';
$session = Session::createSession('SESSION_TOKEN',$sessionData, 10);

echo "Validating Session...";

if($session->validateSession('SESSION_TOKEN')) {
	echo "Ativa";
}else{
	echo "Inativa";
}

//
//$session->createSession($sessionData);
//
$session->dumpSession('SESSION_TOKEN');

$sessionData = array();
$sessionData['user'] = 'borba_v3';
$sessionData['time'] = '09:21';
$sessionData['date'] = '14/06';
$session = Session::createSession('SESSION_TOKEN',$sessionData, 5);

//
Session::killSession();

$sessionData = array();
$sessionData['user'] = 'borba_v3';
$sessionData['time'] = '09:21';
$sessionData['date'] = '14/06';
$session = Session::createSession('SESSION_TOKEN',$sessionData, 2);

/*
This is the usual way we create objects:
$pDatabase = new Database(); 
$aResult = $pDatabase->query('...');  

This is the Singleton way:
$pDatabase = Database::getInstance(); 
$aResult = $pDatabase->query('...');  
*/
?>