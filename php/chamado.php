<?php
@include        ("include/nocache.inc.php");
@require_once   ("include/debug.inc.php");

$action = $_REQUEST['action'];

switch($action) {
	case 'save':
		doSave();
		break;
	case 'search':
		doSearch();
		break;
	case 'find':
		findByCode();
		break;
	default:
}

function doSave(){

	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	// recover parameter
	$id 				= $_REQUEST['id'];
	$cliente 		= $_REQUEST['cliente'];
	$fone   			= $_REQUEST['fone'];
	$veiculo 		= $_REQUEST['veiculo'];
	$cor   			= $_REQUEST['cor'];
	$placa 			= $_REQUEST['placa'];
	$local   		= $_REQUEST['local'];
	$destino 		= $_REQUEST['destino'];
	$valor   		= $_REQUEST['valor'];
	$kminicial 		= $_REQUEST['kminicial'];
	$kmfinal  		= $_REQUEST['kmfinal'];
	$pedagio 		= $_REQUEST['pedagio'];
	$chklist   		= $_REQUEST['chklist'];
	$assistencia 	= $_REQUEST['assistencia'];
	$nrpedido 		= $_REQUEST['nrpedido'];
	$hacionamento  = $_REQUEST['hacionamento'];
	$hconclusao   	= $_REQUEST['hconclusao'];
	$folha 			= $_REQUEST['folha'];
	$servico   		= $_REQUEST['servico'];
	$motorista 		= $_REQUEST['motorista'];
	$frota   		= $_REQUEST['frota'];
	$observacao 	= $_REQUEST['observacao'];
	$atendente		= $_REQUEST['atendente'];
	$notafiscal		= $_REQUEST['notafiscal'];
	$previsao		= $_REQUEST['previsao'];
	$hpassado		= $_REQUEST['hpassado'];
	$aceito			= $_REQUEST['aceito'] == null ? null : dataToDB($_REQUEST['aceito']);

	$ip		=	$_SERVER['REMOTE_ADDR'];
	$data	= 	date('Y-m-d');
	$hora	= 	date('H:i:s');

	// validate Login
	if($id == null){
		$sql  = "INSERT INTO `serviceorder` (cliente, fone, veiculo, cor, placa, local, ";
		$sql .= "destino, valor, kminicial, kmfinal, pedagio, chklist, nrpedido, ";
		$sql .= "hacionamento, hconclusao, folha, atendente, motorista, frota, observacao, ip, data, hora, assistencia, aceito, ";
		$sql .= " notafiscal, servico, hpassado, previsao )";
		$sql .= " VALUES ";
		$sql .= " ('$cliente','$fone', '$veiculo', '$cor', '$placa', '$local', '$destino', ";
		$sql .= "'$valor', '$kminicial', '$kmfinal', '$pedagio', '$chklist', '$nrpedido', ";
		$sql .= "'$hacionamento', '$hconclusao', '$folha', '$atendente', '$motorista', '$frota', ";
		$sql .= "'$observacao', '$ip', '$data', '$hora', '$assistencia', '$aceito', '$notafiscal', '$servico', '$hpassado', '$previsao') ";
	} else {
		$sql  = "UPDATE `serviceorder` SET cliente = '$cliente', fone = '$fone', veiculo = '$veiculo', cor = '$cor', ";
		$sql .= "placa = '$placa', local = '$local',	destino = '$destino', valor = '$valor', kminicial = '$kminicial', kmfinal = '$kmfinal', ";
		$sql .= "pedagio = '$pedagio', chklist = '$chklist', nrpedido = '$nrpedido', hacionamento = '$hacionamento', hconclusao = '$hconclusao', ";
		$sql .= "folha = '$folha', atendente = '$atendente', motorista = '$motorista', frota = '$frota', observacao = '$observacao', assistencia = '$assistencia', ";
		$sql .= "aceito = '$aceito' WHERE id = '$id'";
	}
	
	$file = fopen("log.txt", "a");
	fwrite($file, $sql);
	fclose($file);
		
	// open connection to MySQL-server
	$DBconn = mysql_connect($DBhost,$DBuser,$DBpass);
	// select active database
	mysql_select_db($DBname, $DBconn);
	// use SQL query
	$result = mysql_query($sql, $DBconn);
	
	if(mysql_affected_rows() == 1) {
//		echo json_encode(
//			array('status' => 0)
//		);
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

//funчуo que formata a data
function dataToDB($data)
{
	$data = explode('/', $data);
	$data = $data[2].'-'.$data[1].'-'.$data[0];

	//retorna a string da ordem correta, formatada
	return $data;
} 

function doSearch(){
	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");
	
	$functions 	= new Functions();
	
	$ipaddress	= $_SERVER['REMOTE_ADDR'];
	$date		= date('d/m/Y');
	$time		= date('H:i:s');
	
	// recover parameter
	//$nrpedido = $_REQUEST['nrpedido'];
	
	//if($nrpedido == null) {
		$sql  = "SELECT s.*, a.nome, DATE_FORMAT(aceito,'%d/%m/%Y') AS dtaceito FROM `serviceorder` s, assistencia a ";
		$sql .= " WHERE s.assistencia = a.id ORDER BY s.assistencia, s.nrpedido";
	//} else {
	//	$sql  = "SELECT s.*, a.nome, DATE_FORMAT(aceito,'%d/%m/%Y') AS dtaceito FROM `serviceorder` s, assistencia a ";
	//	$sql .= " WHERE s.assistencia = a.id AND nrpedido = '$nrpedido'";
	//}
	
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
	
	$sql  = "SELECT s.*, a.nome, DATE_FORMAT(aceito,'%d/%m/%Y') AS dtaceito FROM `serviceorder` s, assistencia a ";
	$sql .= " WHERE s.assistencia = a.id AND s.id = '$id'";
	
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