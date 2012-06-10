<?php
@include        ("include/nocache.inc.php");
@require_once   ("include/debug.inc.php");

if(isset($_POST)) {
	doLogin();
}

function doLogin(){

	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	// recover parameter
	$usuario = $_REQUEST['usuario'];
	$senha   = $_REQUEST['senha'];

	$ipaddress	=	$_SERVER['REMOTE_ADDR'];
	$date		= 	date('d/m/Y');
	$time		= 	date('H:i:s');

	$isUsuario 	= $functions->isNullOrEmpty($usuario);
	$isSenha 	= $functions->isNullOrEmpty($senha);

	if(($isUsuario) || ($isSenha)) {
		echo json_encode(array('status'=>100,utf8_encode('message')=>'Usuário ou Senha sem conteúdo.'));
		exit;
	}

	// validate Login
	$sql  = "SELECT * FROM `login` WHERE usuario = '$usuario' AND senha = '$senha'";
	
	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	// select active database
	mysql_select_db($DBname, $DBconn);
	// use SQL query
	$result = mysql_query($sql, $DBconn);
	
	if(mysql_affected_rows() == 1) {
		$data = mysql_fetch_array($result);
		
		// $personID 	= $data['id_person'];
		// $personNAME = $data['name'];

		$sessionData[] = array(
			'usuario'	=>	utf8_encode($usuario),
			'data'		=>	$date,
			'hora'		=>	$time
		);
		
		session_start();
		$_SESSION['SESSION_TOKEN'] = $sessionData;

		echo json_encode(
			array('status' => 0)
		); 
	} else {
	
//		$return = array();
//		$return['status'] = 101;
//		$return['message'] ='Usuário ou Senha incorreto.';
//		echo json_encode($return);
				
		echo json_encode(array(
			'status' => 101,
			utf8_encode('message')=> 'Usuário ou Senha incorreto.'
		));
		exit;
		
	}

}

?>