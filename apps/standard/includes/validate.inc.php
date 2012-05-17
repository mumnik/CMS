<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php	
	function unset_request($key,$requester='unknown'){
		unset($_REQUEST[$key]);
	}

	define('CMS_VALID_OK',		0);
	define('CMS_VALID_ERROR',	1);
	define('CMS_VALID_WARNING',	2);

	function is_int_range($value){
		if( !empty($value) ) foreach(explode(',',$value) as $int_range){
			$int_range = explode('-', $int_range);
			if(count($int_range) > 2) return false;
			foreach($int_range as $int_val)
				if( !is_numeric($int_val) )
					return false;
		}
		return true;
	}
	
	function is_hex_color($value){
		return eregi('^[0-9,A-F]{6}$', $value);
	}
	
	function BETWEEN($min,$max,$var=NULL){
		return '({'.$var.'}>='.$min.'&&{'.$var.'}<='.$max.')&&';
	}

	function GT($value,$var=''){
		return '({'.$var.'}>='.$value.')&&';
	}

	function IN($array,$var=''){
		if(is_array($array)) $array = implode(',', $array);

		return 'str_in_array({'.$var.'},array('.$array.'))&&';
	}
	function HEX($var=NULL){
		return "ereg(\"^[a-zA-Z0-9]{1,}$\",{".$var."})&&";
	}
	function KEY_PARAM($var=NULL){
		return 'ereg(\'^([0-9a-zA-Z\_\.[.'.CMS_EREG_MINUS_SYMB.'.]\$ ]+)$\',{'.$var.'})&&';
	}

	define('NOT_EMPTY',"({}!='')&&");
	define('DB_ID',"({}>=0&&bccomp('{}',\"10000000000000000000\")<0)&&");

//		VAR			TYPE	OPTIONAL FLAGS	VALIDATION	EXCEPTION

	function calc_exp2($fields,$field,$expression){
		foreach($fields as $f => $checks){
/*
			// If an unset variable used in expression, return FALSE
			if(CMS_strstr($expression,'{'.$f.'}')&&!isset($_REQUEST[$f])){
//SDI("Variable [$f] is not set. $expression is FALSE");
//info("Variable [$f] is not set. $expression is FALSE");
//				return FALSE;
			}
//*/
//echo $f,":",$expression,"<br>";
			$expression = str_replace('{'.$f.'}','$_REQUEST["'.$f.'"]',$expression);
//$debug .= $f." = ".$_REQUEST[$f].SBR;
		}

		$expression = trim($expression,'& ');
		$exec = 'return ('.$expression.')?1:0;';
		$ret = eval($exec);
//echo $debug;
//echo "$field - result: ".$ret." exec: $exec".SBR.SBR;
//SDI("$field - result: ".$ret." exec: $exec");
		return $ret;
	}

	function calc_exp($fields,$field,$expression){
//SDI("$field - expression: ".$expression);
		if(CMS_strstr($expression,'{}') && !isset($_REQUEST[$field]))
			return FALSE;

		if(CMS_strstr($expression,'{}') && !is_array($_REQUEST[$field]))
			$expression = str_replace('{}','$_REQUEST["'.$field.'"]',$expression);

		if(CMS_strstr($expression,'{}') && is_array($_REQUEST[$field])){
			foreach($_REQUEST[$field] as $key => $val){
				if(!ereg('^[a-zA-Z0-9_]+$',$key)) return FALSE;

				$expression2 = str_replace('{}','$_REQUEST["'.$field.'"]["'.$key.'"]',$expression);
				if(calc_exp2($fields,$field,$expression2)==FALSE) 
					return FALSE;
			}	
			return TRUE;
		}

//SDI("$field - expression: ".$expression);
		return calc_exp2($fields,$field,$expression);
	}

	function unset_not_in_list(&$fields){
		foreach($_REQUEST as $key => $val){
			if(!isset($fields[$key])){
				unset_request($key,'unset_not_in_list');
			}
		}
	}

	function unset_if_zero($fields){
		foreach($fields as $field => $checks){
			list($type,$opt,$flags,$validation,$exception)=$checks;

			if(($flags&P_NZERO)&&(isset($_REQUEST[$field]))&&(is_numeric($_REQUEST[$field]))&&($_REQUEST[$field]==0)){
				unset_request($field,'unset_if_zero');
			}
		}
	}


	function unset_action_vars($fields){
		foreach($fields as $field => $checks){
			list($type,$opt,$flags,$validation,$exception)=$checks;
			
			if(($flags&P_ACT)&&(isset($_REQUEST[$field]))){
				unset_request($field,'unset_action_vars');
			}
		}
	}

	function unset_all(){
		foreach($_REQUEST as $key => $val){
			unset_request($key,'unset_all');
		}
	}

	function check_type(&$field, $flags, &$var, $type){
		if($type == T_INT_RANGE){
			if( !is_int_range($var) ){
				if($flags&P_SYS){
					info("Critical error. Field [".$field."] is not integer range");
					return CMS_VALID_ERROR;
				}
				else{
					info("Warning. Field [".$field."] is not integer range");
					return CMS_VALID_WARNING;
				}
			}
			return CMS_VALID_OK;
		}
		
		if(($type == T_INT) && !is_numeric($var)) {
			if($flags&P_SYS){
				info("Critical error. Field [".$field."] is not integer");
				return CMS_VALID_ERROR;
			}
			else{
				info("Warning. Field [".$field."] is not integer");
				return CMS_VALID_WARNING;
			}
		}

		if(($type == T_DBL) && !is_numeric($var)) {
			if($flags&P_SYS){
				info("Critical error. Field [".$field."] is not double");
				return CMS_VALID_ERROR;
			}
			else{
				info("Warning. Field [".$field."] is not double");
				return CMS_VALID_WARNING;
			}
		}

		if(($type == T_STR) && !is_string($var)) {
			if($flags&P_SYS){
				info("Critical error. Field [".$field."] is not string");
				return CMS_VALID_ERROR;
			}
			else{
				info("Warning. Field [".$field."] is not string");
				return CMS_VALID_WARNING;
			}
		}
//*		
		if(($type == T_STR) && !defined('CMS_ALLOW_UNICODE') && (strlen($var) != CMS_strlen($var))){
			if($flags&P_SYS){
				info("Critical error. Field [".$field."] contains Multibyte chars");
				return CMS_VALID_ERROR;
			}
			else{
				info("Warning. Field [".$field."] - multibyte chars are restricted");
				return CMS_VALID_ERROR;
			}
		}
//*/
		if(($type == T_CLR) && !is_hex_color($var)) {
			$var = 'FFFFFF';
			if($flags&P_SYS){
				info("Critical error. Field [".$field."] is not color");
				return CMS_VALID_ERROR;
			}
			else{
				info("Warning. Field [".$field."] is not color");
				return CMS_VALID_WARNING;
			}
		}
		return CMS_VALID_OK;
	}

	function check_trim(&$var){
		if(is_string($var)) {
			$var = trim($var);
		}
		else if(is_array($var)){
			foreach($var as $key => $val){
				check_trim($var[$key]);
			}
		}
	}

	function check_field(&$fields, &$field, $checks){
		list($type,$opt,$flags,$validation,$exception)=$checks;

		if($flags&P_UNSET_EMPTY && isset($_REQUEST[$field]) && $_REQUEST[$field]==''){
			unset_request($field,'P_UNSET_EMPTY');
		}

//echo "Field: $field<br>";

		if($exception==NULL)	$except=FALSE;
		else $except=calc_exp($fields,$field,$exception);

		if($opt == O_MAND &&	$except)	$opt = O_NO;
		else if($opt == O_OPT && $except)	$opt = O_MAND;
		else if($opt == O_NO && $except)	$opt = O_MAND;

		if($opt == O_MAND){
			if(!isset($_REQUEST[$field])){
				if($flags&P_SYS){
					info("Critical error. Field [".$field."] is mandatory");
					return CMS_VALID_ERROR;
				}
				else{
					info("Warning. Field [".$field."] is mandatory");
					return CMS_VALID_WARNING;
				}
			}
		}
		else if($opt == O_NO){
			if(!isset($_REQUEST[$field]))
				return CMS_VALID_OK;

			unset_request($field,'O_NO');

			if($flags&P_SYS){
				info("Critical error. Field [".$field."] must be missing");
				return CMS_VALID_ERROR;
			}
			else{
				info("Warning. Field [".$field."] must be missing");
				return CMS_VALID_WARNING;
			}
		}
		else if($opt == O_OPT){
			if(!isset($_REQUEST[$field])){
				return CMS_VALID_OK;
			}
			else if($flags&P_ACT){
				return CMS_VALID_ERROR;
			}
		}

		check_trim($_REQUEST[$field]);

		$err = check_type($field, $flags, $_REQUEST[$field], $type);
		if($err != CMS_VALID_OK)
			return $err;

		if(($exception==NULL)||($except==TRUE)){
			if(!$validation)	$valid=TRUE;
			else			$valid=calc_exp($fields,$field,$validation);

			if(!$valid){
				if($flags&P_SYS){
					info("Critical error. Incorrect value for [".$field."] = '".$_REQUEST[$field]."'");
					return CMS_VALID_ERROR;
				}
				else{
					info("Warning. Incorrect value for [".$field."]");
					return CMS_VALID_WARNING;
				}
			}
		}

		
		return CMS_VALID_OK;
	}

//		VAR							TYPE	OPTIONAL FLAGS	VALIDATION	EXCEPTION
	$system_fields=array(
	);

	function invalid_url(){
		include_once "include/page_header.php";
		unset_all();
		show_error_message(S_INVALID_URL);
		include_once "include/page_footer.php";
	}
	
	function check_fields(&$fields, $show_messages=true){
		global	$system_fields;

		$err = CMS_VALID_OK;

		$fields = array_merge($fields, $system_fields);

		foreach($fields as $field => $checks){
			$err |= check_field($fields, $field,$checks);
		}

		unset_not_in_list($fields);
		unset_if_zero($fields);
		if($err!=CMS_VALID_OK){
			unset_action_vars($fields);
		}

		$fields = null;
		
		if($err&CMS_VALID_ERROR){
			invalid_url();
		}

		if($show_messages) show_messages();

		return ($err==CMS_VALID_OK ? 1 : 0);
	}
?>
