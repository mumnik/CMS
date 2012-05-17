<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
global $CONF;

$CONF['SELECT_COUNT'] = 0;
$CONF['EXECUTE_COUNT'] = 0;

/* string value prepearing */
if(isset($CONF['dbtype']) && $CONF['dbtype'] == 'ORACLE') {
	function db_str($var)	{
		return "'".ereg_replace('\'','\'\'',$var)."'";	
	}
	
	function db_cast_2bigint($field){
		return ' CAST('.$field.' AS NUMBER(20)) ';
	}
}
else if(isset($CONF['dbtype']) && $CONF['dbtype'] == "MYSQL") {
	function db_str($var)	{
		return "'".mysql_real_escape_string($var)."'";
	}
	
	function db_cast_2bigint($field){
		return ' CAST('.$field.' AS UNSIGNED) ';
	}
}
else if(isset($CONF['dbtype']) && $CONF['dbtype'] == "PGSQL") {
	function db_str($var)	{
		return "'".pg_escape_string($var)."'";
	}
	
	function db_cast_2bigint($field){
		return ' CAST('.$field.' AS BIGINT) ';
	}
}
else {			
	function db_str($var)	{
		return "'".addslashes($var)."'";
	}
	
	function db_cast_2bigint($field){
		return ' CAST('.$field.' AS BIGINT) ';
	}
}

function DBconnect(&$error){
	global $CONF;
	
	$result = true;

	$CONF['db'] = null;
	$CONF['transactions'] = 0;
	
//Stats
	$CONF['SELECT_COUNT'] = 0;
	$CONF['EXECUTE_COUNT'] = 0;

//SDI('type: '.$CONF['dbtype'].'; server: '.$CONF['dbserver'].'; port: '.$CONF['dbport'].'; db: '.$CONF['dbase'].'; usr: '.$CONF['dbuser'].'; pass: '.$CONF['dbpass']);
	switch($CONF['dbtype']){
		case 'MYSQL':
			$mysql_server = $CONF['dbserver'].( !empty($CONF['dbport']) ? ':'.$CONF['dbport'] : '');

			if (!$CONF['db']= mysql_pconnect($mysql_server,$CONF['dbuser'],$CONF['dbpass'])){
				$error = 'Error connecting to database ['.mysql_error().']';
				$result = false;
			}
			else{
				if (!mysql_select_db($CONF['dbase'])){
					$error = 'Error database selection ['.mysql_error().']';
					$result = false;
				}
				else{
					DBexecute('SET NAMES "utf8"');
					DBexecute('SET CHARACTER SET "utf8"');
				}
			}
			break;
		case 'PGSQL':
			$pg_connection_string = 
				( !empty($CONF['dbserver']) ? 'host=\''.$CONF['dbserver'].'\' ' : '').
				'dbname=\''.$CONF['dbase'].'\' '.
				( !empty($CONF['dbuser']) ? 'user=\''.$CONF['dbuser'].'\' ' : '').
				( !empty($CONF['dbpass']) ? 'password=\''.$CONF['dbpass'].'\' ' : '').
				( !empty($CONF['dbport']) ? 'port='.$CONF['dbport'] : '');

			$CONF['db']= pg_connect($pg_connection_string);
			if(!$CONF['db']){
				$error = 'Error connecting to database';
				$result = false;
			}
			break;
		case 'ORACLE':
			$CONF['db']= ociplogon($CONF['dbuser'], $CONF['dbpass'], $CONF['dbase']);
//					$CONF['db']= ociplogon($CONF['dbuser'], $CONF['dbpass'], '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.$CONF['dbserver'].')(dbport=1521))(CONNECT_DATA=(SERVICE_NAME='.$CONF['dbase'].')))');
			if(!$CONF['db']){
				$error = 'Error connecting to database';
				$result = false;
			}
			break;
		default:
			$error = 'Unsupported database';
			$result = false;
	}

	if( false == $result )
		$CONF['db']= null;

return $result;
}


function DBnextautoincrement($tablename=false){
	if ($tablename)	{
		$r = mysql_query("SHOW TABLE STATUS LIKE '$tablename' ");
		$row = mysql_fetch_array($r);
		$Auto_increment = $row['Auto_increment'];
		mysql_free_result($r);
		return $Auto_increment;	
	} else {
		return false;	
	}
}

function DBclose(){
	global $CONF;
	$result = false;

	if( isset($CONF['db']) && !empty($CONF['db']) ){
		switch($CONF['dbtype']){
			case 'MYSQL':		
				$result = mysql_close($CONF['db']);	
				break;
			case 'PGSQL':
				$result = pg_close($CONF['db']);
				break;
			case 'ORACLE':
				$result = ocilogoff($CONF['db']);
				break;
			default:		break;
		}
	}

	unset($GLOBALS['db']);
	
return $result;
}

function DBstart($comments=false){
	global $CONF;
//SDI('DBStart(): '.$CONF['transactions']);
	$CONF['COMMENTS'] = $comments;
	if($CONF['COMMENTS']) info(S_TRANSACTION.': '.S_STARTED_BIG);
	
	$CONF['transactions']++;

	if($CONF['transactions']>1){
		info('POSSIBLE ERROR: Used incorect logic in database processing, started subtransaction!');
	return $CONF['TRANSACTION_STATE'];
	}
	
	$CONF['TRANSACTION_STATE'] = true;
	
	$result = false;
	if(isset($CONF['db']) && !empty($CONF['db']))
	switch($CONF['dbtype']){
		case 'MYSQL':
			$result = DBexecute('begin');
			break;
		case 'PGSQL':
			$result = DBexecute('begin');
			break;
		case 'ORACLE':
			$result = true;
// TODO			OCI_DEFAULT
			break;
	}
return $result;
}


function DBend($result=null){
	global $CONF;
//SDI('DBend(): '.$CONF['transactions']);
	if($CONF['transactions'] != 1){
		$CONF['transactions']--;
		
		if($CONF['transactions'] < 1){
			$CONF['transactions'] = 0;
			$CONF['TRANSACTION_STATE'] = false;
			info('POSSIBLE ERROR: Used incorect logic in database processing, transaction not started!');
		}
	return $CONF['TRANSACTION_STATE'];
	}

	$CONF['transactions'] = 0;
	
	if(is_null($result)){
		$db_result = $CONF['TRANSACTION_STATE'];
	}
	else{
		$db_result = $result && $CONF['TRANSACTION_STATE'];
	}
		
//SDI('Result: '.$result);

	if($db_result){ // OK
		$db_result = DBcommit();
	}
	
//	$msg = S_TRANSACTION.': '.S_COMMITED_BIG;
	if(!$db_result){ // FAIL
		DBrollback();
//		$msg = S_TRANSACTION.': '.S_ROLLBACKED_BIG;
	}
	if($CONF['COMMENTS']) info($msg);
	
	$result = (!is_null($result) && $db_result)?$result:$db_result;
	
return $result;
}

function DBcommit(){
	global $CONF;
	
	$result = false;
	if( isset($CONF['db']) && !empty($CONF['db']) )
	switch($CONF['dbtype']){
		case 'MYSQL':
			$result = DBexecute('commit');
			break;
		case 'PGSQL':
			$result = DBexecute('commit');
			break;
		case 'ORACLE':
			$result = ocicommit($CONF['db']);

			break;
	}
			
return $result;
}

function DBrollback(){
	global $CONF;

	$result = false;
	if( isset($CONF['db']) && !empty($CONF['db']) )
	switch($CONF['dbtype']){
		case 'MYSQL':
			$result = DBexecute('rollback');
			break;
		case 'PGSQL':
			$result = DBexecute('rollback');
			break;
		case 'ORACLE':
			$result = ocirollback($CONF['db']);
			break;
	}
	
return $result;
}


/* NOTE:
	LIMIT and OFFSET records
	
	Example: select 6-15 row.

	MySQL:	
		SELECT a FROM tbl LIMIT 5,10
		SELECT a FROM tbl LIMIT 10 OFFSET 5
	PostgreSQL:
		SELECT a FROM tbl LIMIT 10 OFFSET 5
	Oracle:
		SELECT a FROM tbe WHERE ROWNUM < 15 // ONLY < 15
		SELECT * FROM (SELECT ROWNUM as RN, * FROM tbl) WHERE RN BETWEEN 6 AND 15
*/

function &DBselect($query, $limit='NO', $offset=0){
	global $CONF;
//COpt::savesqlrequest($query);
	$result = false;
	
	if( isset($CONF['db']) && !empty($CONF['db']) ){
//SDI('SQL: '.$query);
		$CONF['SELECT_COUNT']++;
		
		switch($CONF['dbtype']){
			case 'MYSQL':
				if(cms_numeric($limit)){
					$query .= ' LIMIT '.intval($limit).' OFFSET '.intval($offset);
				}
				$result=mysql_query($query,$CONF['db']);
				if(!$result){
					error('Error in query ['.$query.'] ['.mysql_error().']');
				}
				break;
			case 'PGSQL':
				if(cms_numeric($limit)){
					$query .= ' LIMIT '.intval($limit).' OFFSET '.intval($offset);
				}
				$result = pg_query($CONF['db'],$query);
				if(!$result){
					error('Error in query ['.$query.'] ['.pg_last_error().']');
				}
				break;
			case 'ORACLE':
				if(cms_numeric($limit)){
//						$query = 'select * from ('.$query.') where rownum<='.intval($limit);
					$query = 'select * from ('.$query.') where rownum between '.intval($offset).' and '.intval($limit);
				}
				$result = DBexecute($query);
				if(!$result){
					$e = ocierror($result);
					error('SQL error ['.$e['message'].'] in ['.$e['sqltext'].']');
				}

				break;
		}
		
		if($CONF['transactions'] && !$result){
			$CONF['TRANSACTION_STATE'] &= $result;
//			SDI($query);
//			SDI($CONF['TRANSACTION_STATE']);
		}
	}		
return $result;
}

function DBexecute($query, $skip_error_messages=0){
	global $CONF;
//COpt::savesqlrequest($query);
	$result = false;

	if( isset($CONF['db']) && !empty($CONF['db']) ){
		$CONF['EXECUTE_COUNT']++;	// WRONG FOR ORACLE!!
//SDI('SQL Exec: '.$query);
		switch($CONF['dbtype']){
			case 'MYSQL':
				$result=mysql_query($query,$CONF['db']);

				if(!$result){
					error('Error in query ['.$query.'] ['.mysql_error().']');
				}
				break;
			case 'PGSQL':
				$result = pg_query($CONF['db'],$query);
				if(!$result){
					error('Error in query ['.$query.'] ['.pg_last_error().']');
				}
				break;
			case 'ORACLE':
				$stid=OCIParse($CONF['db'],$query);
				if(!$stid){
					$e=@ocierror();
					error('SQL error ['.$e['message'].'] in ['.$e['sqltext'].']');
				}
				
				$result=@OCIExecute($stid,($CONF['transactions']?OCI_DEFAULT:OCI_COMMIT_ON_SUCCESS));
				if(!$result){
					$e=ocierror($stid);
					error('SQL error ['.$e['message'].'] in ['.$e['sqltext'].']');
				}
				else{
					$result = $stid;
				}

				break;
		}
		
		if($CONF['transactions'] && !$result){
			$CONF['TRANSACTION_STATE'] &= $result;
//			SDI($query);
//			SDI($CONF['TRANSACTION_STATE']);
		}
	}
return $result;
}

function DBfetch(&$cursor){
	global $CONF;

	$result = false;
	
	if(isset($CONF['db']) && !empty($CONF['db']))
	switch($CONF['dbtype']){
		case 'MYSQL':
			$result = mysql_fetch_assoc($cursor);
			break;
		case 'PGSQL':
			$result = pg_fetch_assoc($cursor);
			break;
		case 'ORACLE':
			if(ocifetchinto($cursor, $row, (OCI_ASSOC+OCI_RETURN_NULLS))){
				$result = array();
				foreach($row as $key => $value){
					$result[strtolower($key)] = (str_in_array(strtolower(ocicolumntype($cursor,$key)),array('varchar','varchar2','blob','clob')) && is_null($value))?'':$value;
				}
			}
			break;
	}

return $result;
}

function get_dbid($table,$field){
	$found = false;
	$min = 0;

	do{
		$row = DBfetch(DBselect("SELECT nextid FROM ids WHERE table_name='$table' AND field_name='$field'"));
		if(!$row){
			$row=DBfetch(DBselect('SELECT max('.$field.') AS id FROM '.$table));
			if(!$row || is_null($row['id'])){
				DBexecute('INSERT INTO ids (table_name,field_name,nextid) '." VALUES ('$table','$field',$min)");
			}
			else{
				DBexecute("INSERT INTO ids (table_name,field_name,nextid) VALUES ('$table','$field',".$row['id'].')');
			}
			
			continue;
		}
		else{
			$ret1 = $row['nextid'];
			if($ret1 < $min){
				DBexecute("DELETE FROM ids WHERE table_name='$table' AND field_name='$field'");
				continue;
			}

			DBexecute("UPDATE ids SET nextid=nextid+1 WHERE table_name='$table' AND field_name='$field'");

			$row = DBfetch(DBselect("SELECT nextid FROM ids WHERE table_name='$table' AND field_name='$field'"));
			if(!$row || is_null($row['nextid'])){
				/* Should never be here */
				continue;
			}
			else{
				$ret2 = $row['nextid'];
				if(($ret1+1) == $ret2){
					$found = true;
				}
			}
		}
	}
	while(false == $found);

return $ret2;
}

function DBprepare_insert($table, $db_fields, $data){
	$sql_fields = '';
	$sql_values = '';

	foreach($db_fields as $key => $def){
		if(!isset($data[$key]) || cms_empty($data[$key])) $data[$key] = $def['value'];

		$sql_fields.=$table.'.'.$key.',';
		if($def['type'] == T_STR)
			$sql_values.=db_str($data[$key]).',';
		else{
			$data[$key] = preg_replace('/[^0-9]*/','',$data[$key]);
			$sql_values.=$data[$key].',';
		}
	}
	$sql_fields = rtrim($sql_fields,',');
	$sql_values = trim($sql_values,',');

	$sql = 'INSERT INTO '.$table.' ('.$sql_fields.') VALUES ('.$sql_values.')';
return $sql;
}

function DBprepare_update($tableid, $id, $table, $db_fields, $data, $string=false){
	cms_value2array($id);

	$sql_fields = '';
	foreach($db_fields as $key => $def){
		if(!isset($data[$key])){
			if(is_null($def['value'])) continue;
			$data[$key] = $def['value'];
		}
			
		$sql_fields.= $table.'.'.$key.'=';
		if($def['type'] == T_STR)
			$sql_fields.=db_str($data[$key]).',';
		else{
			$data[$key] = preg_replace('/[^0-9]*/','',$data[$key]);
			$sql_fields.=$data[$key].',';
		}
	}
	$sql_fields = rtrim($sql_fields,',');

	$sql = 'UPDATE '.$table.' SET '.$sql_fields.' WHERE '.DBcondition($tableid,$id,null,$string);
return $sql;
}

function DBcondition($fieldname, &$array, $notin=false, $string=false){
	global $CONF;
	$condition = '';
	
	if(!is_array($array)){
		info('DBcondition Error: ['.$fieldname.'] = '.$array);
		$array = explode(',',$array);
		if(empty($array))
			return ' 1=0 ';
	}

	$in = 		$notin?' NOT IN ':' IN ';
	$concat = 	$notin?' AND ':' OR ';
	$glue = 	$string?"','":',';

	switch($CONF['dbtype']) {
		case 'MYSQL':
		case 'PGSQL':
		case 'ORACLE':
		default:
			$items = array_chunk($array, 950);
			foreach($items as $id => $values){
				$condition.=!empty($condition)?')'.$concat.$fieldname.$in.'(':'';
				
				if($string)	$condition.= "'".implode($glue,$values)."'";
				else		$condition.= implode($glue,$values);
			}
			break;
	}
	
	if(cms_empty($condition)) $condition = $string?"'-1'":'-1';

return ' ('.$fieldname.$in.'('.$condition.')) ';
}

?>