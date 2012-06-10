<?php
@include        ("include/nocache.inc.php");
@require_once   ("include/debug.inc.php");

$action = $_REQUEST['action'];

switch($action) {
	case 'calc':
		calculate();
		break;
	default:
}

//funчуo que formata a data
function dataToDB($data)
{
	$data = explode('/', $data);
	$data = $data[2].'-'.$data[1].'-'.$data[0];

	//retorna a string da ordem correta, formatada
	return $data;
} 

function calculate(){

	@require_once ("include/functions.inc.php");
	@require_once ("include/config.inc.php");

	$functions = new Functions();

	// recover parameter
	$motorista 	= $_REQUEST['motorista'];
	$dtini   	= $_REQUEST['dtini'] == null ? null : dataToDB($_REQUEST['dtini']);
	$dtfin 		= $_REQUEST['dtfin'] == null ? null : dataToDB($_REQUEST['dtfin']); 

	$ip		=	$_SERVER['REMOTE_ADDR'];
	$data	= 	date('Y-m-d');
	$hora	= 	date('H:i:s');

	$sql  = "SELECT DATE_FORMAT(aceito,'%d/%m/%Y') AS dtaceito, s.valor, m.nome, m.percent, s.veiculo, s.placa, (s.valor*(m.percent/100)) as total ";
	$sql .= "FROM `serviceorder` s, `motorista` m ";
	$sql .= "WHERE s.motorista = '$motorista' ";
	$sql .= "AND s.motorista = m.id ";
	$sql .= "AND s.aceito BETWEEN '$dtini' AND '$dtfin' ";
	$sql .= "ORDER BY s.aceito ";
	
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