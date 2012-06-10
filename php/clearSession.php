<?php
@session_start();

$_SESSION = array();
@session_destroy();
@session_unset();

$retcode = "000";

echo json_encode(array("status" => $retcode));
?>