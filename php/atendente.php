<?php
@include        ("include/nocache.inc.php");
@require_once   ("include/debug.inc.php");

$action = $_REQUEST['action'];

switch($action) {
	case 'getall':
		getAll();
		break;
	case 'save':
		doSave();
		break;
	case 'search':
		doSearch();
		break;
	case 'find':
		findByCode();
		break;
	case 'delete':
		delete();
		break;
	default:
}

function delete(){

	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	// recover parameter
	$nome 	= $_REQUEST['nome'];
	$cpf 	= $_REQUEST['cpf'];
	$id 	= $_REQUEST['id'];

	$ip		=	$_SERVER['REMOTE_ADDR'];
	$data	= 	date('Y-m-d');
	$hora	= 	date('H:i:s');

	$sql  = "SELECT atendente FROM `serviceorder` WHERE atendente = '$id'";
	
	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	// select active database
	mysql_select_db($DBname, $DBconn);
	// use SQL query
	$result = mysql_query($sql, $DBconn);
	
	if(mysql_affected_rows() >= 1) {
		echo json_encode(array(
			'status' => 300,
			utf8_encode('msg')	=> 'AVISO: ATENDENTE - não pode ser removido(a).'
		));
	} else {
		$sql  = "DELETE FROM `atendente` WHERE id = '$id'";
		
		// open connection to MySQL-server
		$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
		// select active database
		mysql_select_db($DBname, $DBconn);
		// use SQL query
		$result = mysql_query($sql, $DBconn);
		
		if(mysql_affected_rows() == 1) {
			echo json_encode(array(
				'status' => 0,
				utf8_encode('msg')	=> 'SUCESSO: ATENDENTE - removido(a).'
			));
		} else {
			echo json_encode(array(
				'status' => 200,
				utf8_encode('msg')	=> 'ERRO: ao remover ATENDENTE.'
			));
			exit;
		}
		
	}

}

function doSave(){

	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	// recover parameter
	$nome 	= $_REQUEST['nome'];
	$cpf 	= $_REQUEST['cpf'];
	$id 	= $_REQUEST['id'];

	$ip		=	$_SERVER['REMOTE_ADDR'];
	$data	= 	date('Y-m-d');
	$hora	= 	date('H:i:s');

	if($id == null){
		$sql  = "INSERT INTO `atendente` (nome, cpf) VALUES ('$nome', '$cpf') ";
	}else {
		$sql  = "UPDATE `atendente` SET nome = '$nome', cpf = '$cpf' WHERE id = '$id'";
	}
	
	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	// select active database
	mysql_select_db($DBname, $DBconn);
	// use SQL query
	$result = mysql_query($sql, $DBconn);
	
		if(mysql_affected_rows() == 1) {
			echo json_encode(array(
				'status' => 0,
				utf8_encode('msg')	=> 'Gravado com sucesso.'
			));
	 
		} else {
			echo json_encode(array(
				'status' => 200,
				utf8_encode('msg')	=> 'Erro ao gravar no banco e dados.'
			));
			exit;
			
		}

}

function getAll(){
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");
	
	$functions = new Functions();
	
	$ipaddress	=	$_SERVER['REMOTE_ADDR'];
	$date		= 	date('d/m/Y');
	$time		= 	date('H:i:s');
	
	// validate Login
	$sql  = "SELECT * FROM `atendente` ";
	
	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	
	// select active database
	mysql_select_db($DBname, $DBconn);
	
	// use SQL query
	$result = mysql_query($sql, $DBconn);
	
	$return = array();
	while ($dados = mysql_fetch_assoc($result)) {
		array_push($return, $dados);
	}
	
	echo json_encode($return);

}

function doSearch(){
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");
	
	$functions = new Functions();
	
	$ipaddress	=	$_SERVER['REMOTE_ADDR'];
	$date		= 	date('d/m/Y');
	$time		= 	date('H:i:s');
	
	// recover parameter
	$nome = $_REQUEST['nome'];
	
	if(isset($nome)){
		$sql  = "SELECT * FROM `atendente` WHERE LOWER(nome) LIKE LOWER('%$nome%')";
	} else {
		$sql  = "SELECT * FROM `atendente`";
	}

	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	
	// select active database
	mysql_select_db($DBname, $DBconn);
	
	// use SQL query
	$result = mysql_query($sql, $DBconn);
	
	$return = array();
	while ($dados = mysql_fetch_assoc($result)) {
		array_push($return, $dados);
	}

	echo json_encode($return);

}

function findByCode(){
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");
	
	$functions = new Functions();
	
	$ipaddress	=	$_SERVER['REMOTE_ADDR'];
	$date		= 	date('d/m/Y');
	$time		= 	date('H:i:s');
	
	// recover parameter
	$id = $_REQUEST['id'];
	
	$sql  = "SELECT * FROM `atendente` WHERE id = '$id'";
	
	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	
	// select active database
	mysql_select_db($DBname, $DBconn);
	
	// use SQL query
	$result = mysql_query($sql, $DBconn);
	
	$return = array();
	while ($dados = mysql_fetch_assoc($result)) {
		array_push($return, $dados);
	}

	echo json_encode($return);

}


?>