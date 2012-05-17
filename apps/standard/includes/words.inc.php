<?php



function saveWord($word, $wordid=0){

	$db_fields = array(	
			'string' =>		array('type'=>T_STR, 'value'=>''),
			'lang' =>		array('type'=>T_STR, 'value'=>''),
			'data' =>		array('type'=>T_STR, 'value'=>'')
			);
			
// UPDATE
	if($wordid > 0){
		$sql = DBprepare_update('wordid', $wordid, 'words', $db_fields, $word);
	}
	
// INSERT
	else{
		//$wordid = $word['wordid'] = get_dbid('words', 'wordid');
		$sql = DBprepare_insert('words', $db_fields, $word);
	}

	$result = DBexecute($sql);
	
return $result?$wordid:false;
}

function deleteWords($wordids){
	cms_value2array($wordids);
	
	$sql = 'DELETE FROM words WHERE '.Dbcondition('wordid', $wordids);
	$result = DBexecute($sql);
return $result;
}

function getword($w){
	return get_word($w);
}
	
function get_word($word, $nocache=0){
global $ln;

	if ($word==null)
		return false;
		
	if ($ln==null)	
		return false;
	
	static $words = array();		
	
	if(!count($words[$ln]))
	{
		$sql = 'SELECT DISTINCT w.*'.
				' FROM words w '.
				' WHERE w.lang='.db_str($ln);
		$res = DBselect($sql);
		while($data = DBfetch($res))
			$words[$ln][$data['string']] = $data['data'];		
	}			
			
	return isset($words[$ln][$word]) ? $words[$ln][$word] : 'unknown['.$word.']';	
}

function getCurrentWords(){
	global $ln;
	
	$result = getWords($ln);
return $result;
}

function getWords($lang){
	$result=array();
	
	$sql = 'SELECT DISTINCT w.* '.
			' FROM words w '.
			' WHERE w.lang='.db_str($lang).
			' ORDER BY w.data';		
	$res = DBselect($sql);
	while($row = DBfetch($res)){
		$result[$row['string']]=$row['data'];
	}
return $result;
}

function getFullWords($lang){
	$result=array();
	
	$sql = 'SELECT DISTINCT w.* '.
			' FROM words w '.
			' WHERE w.lang='.db_str($lang).
			' ORDER BY w.data';		
	$res = DBselect($sql);
	while($row = DBfetch($res)){
		$result[$row['string']] = $row;
	}
return $result;
}
?>