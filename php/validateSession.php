<?php

@include ('Sesison.class.php');

$_COOKIE

session_start();
@session_destroy();
@session_unset();

//$sessionData[] = array(
//	'usuario'	=>	utf8_encode('borba_v1'),
//	'data'		=>	'14/06',
//	'hora'		=>	'10:15'
//);
//array(1) { [0]=> array(3) { ["usuario"]=> string(8) "borba_v1" ["data"]=> string(5) "14/06" ["hora"]=> string(5) "10:15" } }

$sessionData = array();
$sessionData['user'] = 'borba_v2';
$sessionData['time'] = '09:21';
$sessionData['date'] = '14/06';
//array(3) { ["user"]=> string(8) "borba_v2" ["time"]=> string(5) "09:21" ["date"]=> string(5) "14/06" }

//$_SESSION['SESSION_TOKEN']['user'] = 'borba_v3';
//$_SESSION['SESSION_TOKEN']['time'] = '09:21';
//$_SESSION['SESSION_TOKEN']['date'] = '14/06';
//array(3) { ["user"]=> string(8) "borba_v3" ["time"]=> string(5) "09:21" ["date"]=> string(5) "14/06" }

$_SESSION['SESSION_TOKEN'] = $sessionData;

var_dump($_SESSION['SESSION_TOKEN']);

echo $_SESSION['SESSION_TOKEN']['user'];


//session_cache_expire( 20 );
//session_start(); // NEVER FORGET TO START THE <strong class="highlight">SESSION</strong>!!!
//$inactive = 1200;
//if(isset($_SESSION['start']) ) {
//	$session_life = time() - $_SESSION['start'];
//	if($session_life > $inactive){
//		header("Location: user_logout.php");
//	}
//}
//$_SESSION['start'] = time();
//
//if($_SESSION['valid_user'] != true){
//header('Location: ../index.php');
//
//}else{
//

//
//if (!isset($_SESSION['CREATED'])) {
//    $_SESSION['CREATED'] = time();
//} else if (time() - $_SESSION['CREATED'] > 1800) {
    // session started more than 30 minates ago
//    session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
//    $_SESSION['CREATED'] = time();  // update creation time
//}
//


//if(!isset($_SESSION['SESSION_TOKEN']){
//	echo 'not set';
//}else{
//	echo 'setted';
//}


//echo "borba";
//exit;
//
//@session_start();
//
//$retcode = "000";
//
//
//echo $_SESSION['SESSION_TOKEN']['hora'];
//exit;
//
//
// 10 min
//$inactive = 600;
//$session_life = time() - $_SESSION['timeout'];
//
//if($session_life > $inactive) || (!isset($_SESSION["SESSION_TOKEN"])) {
//	$_SESSION = array();
//	@session_destroy();
//	$retcode = "999";
//}
//
//echo json_encode(array("status" => $retcode));

?>