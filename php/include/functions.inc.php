<?php 

class Functions {
	
	public function doSQL($action, $array=null, $table, $where=null) {

		// $record = array();
		// $record['campo1'] = "caca";
		// $record['campo2'] = "xico";
		// $record['campo3'] = "massa";
		// 
		// $where = array();
		// $where['campo99'] = 1;

		// echo doSQL("insert", $record, "TABELA" );

		// echo doSQL("update", $record, "TABELA", $where);

		// echo doSQL("delete", "", "TABELA", $where);

		$sql = "";

		if($action == "insert") {
			$sql =  "INSERT INTO `$table` ( "; 

			foreach ($array as $i => $value) {		
				$campos .= $i . ", ";
			}

			$sql .= substr( $campos, 0, strlen($campos)-2) . " ) VALUES ( ";

			foreach ($array as $i => $value) {
				$conteudo .= "'" . $array[$i] . "'" . ", ";
			}

			$sql .= substr( $conteudo, 0, strlen($conteudo)-2) . " ); ";

		} else if($action == "update") {
			$sql =  "UPDATE `$table` SET "; 

			foreach ($array as $i => $value) {		
				$campos .= $i . "=" . "'" . $value . "', ";
			}

			$sql .= substr( $campos, 0, strlen($campos)-2);

			foreach ($where as $i => $value) {
				$where = " WHERE $i = " . $value;
			}

			$sql .= $where;
		} else if($action=="delete") {
			$sql =  "DELETE FROM `$table` WHERE "; 

			foreach ($where as $i => $value) {
				$where = " $i = " . $value;
			}

			$sql .= $where;

		}

		return $sql;	
	}
	
	public function DeltaPerc($val1, $val2) {
		/*
		$val1 =  9.645
		$val2 = 21.935
		
		1)	9.645 : 21.935 = 0,43970 * 100 = 43,97%
			
		2)	21.935 - 9.645 = 12.290

			21.935 = 100%
			12.290 = x%

			21935x = 12290 x 100
			x = 1229000 : 21935
			x = 56,02%

			Em outras palavras, você estaria subtraindo 100% de cerca de 43,98%, 
			cujo resultado seria aproximadamente 56,02%
		*/
		
		$_val = 0;
		
		try {
			if($val1 != 0){
				$_val = (($val1 - $val2)/$val1)*100;
				$_val = number_format($_val, 2, '.', '') . "%";
			}
		}catch(Exception $e){
			$_val = 0;
		}

		return $_val;
	}
	
	public function isNullOrEmpty($condition){
		$bRet = false;
		if (empty($condition) || is_null($condition)) { 
			$bRet = true; 
		}		
		return $bRet;
	}
	
	public function hasValue($string) {
		return isset($string) ? $string : null;
	}
	
	public function NullOrValue($condition){
		$bRet = $condition;
		if (empty($condition) || is_null($condition)) { 
			$bRet = ""; 
		}		
		return $bRet;
	}
	
	public function dateconvert($date,$func) {
		// to database 
		if ($func == 1){
			$value = explode("/",$date);
			return "$value[2]-$value[1]-$value[0]";
		// to screen
		}elseif ($func == 2){
			$data_nova = explode("-",$date);
			return $data_nova[2]."/".$data_nova[1]."/".$data_nova[0];
		}
	}
	
	public function valueconvert($value,$func){
		// to database
		if($func == 1){
//			$_newValue = number_format($value, 2, '.', '');
			 
//			setlocale(LC_MONETARY, 'en_US');
//			return number_format(str_replace(",","",$value),2,".","");
			$_newValue = str_replace(",", ".", $value);
//			$_newValue = $this->money_format('%=*(#10.2n', $value);
		// form database
		}elseif($func == 2){ 
			$_newValue = number_format($value, 2, ',', '');

//			setlocale(LC_MONETARY, 'it_IT');
//			return $value.number_format(str_replace(".","",$value),2,",",".");
//			$_newValue = str_replace(".", ",", $value);
//			$_newValue =  $this->money_format('%.2n', $value);
		}
		
		return $_newValue;
	}
	
	public function isValidEmail($email){
	   // check if email is valid
	   if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"
	   ."@([a-z0-9]+([\.-][a-z0-9]+))*$",$email, $regs)){
	      return false;
	   } else if( gethostbyname($regs[2]) == $regs[2] ){
	      // if host is invalid
	      return false;
	   } else {
	      return true;
	   }
	}

	public function isValidUserName($name){
	   // check valid input name
	   if(!eregi("^[a-z0-9]{8,15}$",$name)){
	      return false;
	   } else {
	      return true;
	   }
	}

	public function isValidPassword($pwd){
	   // check valid password
	   if(!eregi("^[a-z0-9]{6,8}$",$pwd))
	   {
	      return false;
	   } else {
	      return true;
	   }
	}

	public function getmicrotime() {
	    $time = microtime();
	    $time = explode(" ",$time);
	    return ($time[1] . substr($time[0],2,3));
	}
	
	public function money_format($format, $number)
	{
		$regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
				  '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
		if (setlocale(LC_MONETARY, 0) == 'C') {
			setlocale(LC_MONETARY, '');
		}
		$locale = localeconv();
		preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
		foreach ($matches as $fmatch) {
			$value = floatval($number);
			$flags = array(
				'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
							   $match[1] : ' ',
				'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
				'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
							   $match[0] : '+',
				'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
				'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
			);
			$width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
			$left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
			$right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
			$conversion = $fmatch[5];

			$positive = true;
			if ($value < 0) {
				$positive = false;
				$value  *= -1;
			}
			$letter = $positive ? 'p' : 'n';

			$prefix = $suffix = $cprefix = $csuffix = $signal = '';

			$signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
			switch (true) {
				case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
					$prefix = $signal;
					break;
				case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
					$suffix = $signal;
					break;
				case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
					$cprefix = $signal;
					break;
				case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
					$csuffix = $signal;
					break;
				case $flags['usesignal'] == '(':
				case $locale["{$letter}_sign_posn"] == 0:
					$prefix = '(';
					$suffix = ')';
					break;
			}
			if (!$flags['nosimbol']) {
				$currency = $cprefix .
							($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
							$csuffix;
			} else {
				$currency = '';
			}
			$space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

			$value = number_format($value, $right, $locale['mon_decimal_point'],
					 $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
			$value = @explode($locale['mon_decimal_point'], $value);

			$n = strlen($prefix) + strlen($currency) + strlen($value[0]);
			if ($left > 0 && $left > $n) {
				$value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
			}
			$value = implode($locale['mon_decimal_point'], $value);
			if ($locale["{$letter}_cs_precedes"]) {
				$value = $prefix . $currency . $space . $value . $suffix;
			} else {
				$value = $prefix . $value . $space . $currency . $suffix;
			}
			if ($width > 0) {
				$value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
						 STR_PAD_RIGHT : STR_PAD_LEFT);
			}

			$format = str_replace($fmatch[0], $value, $format);
		}
		return $format;
	} 	
}
?>