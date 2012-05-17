<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

function makemodulesarray(){
	$result=array();
	
	$sql = 'SELECT DISTINCT module FROM modules WHERE enabled=1';
	$res = DBSELECT($sql);
	while($row=DBfetch($res)){
		$result[]=$row['module'];
	}
return $result;
}

function makemodulesarray_full(){
	$result=array();
	
	$sql = 'SELECT DISTINCT module FROM modules';
	$res = DBSELECT($sql);
	while($row=DBfetch($res)){
		$result[]=$row['module'];
	}
return $result;
}

function getcurrentmoduleparent(){
	global $module;
	$result = getmoduleparent($module);
return $result;
}

function getmoduleparent($mdl){
	$result = false;
	
	$sql = 'SELECT parent FROM modules WHERE module='.db_str($mdl);
	if($res = DBSELECT($sql,1)){
		$row = DBfetch($res);
		$result = $row['parent'];
	}
return $result;
}

function getmenumodules(){
	global $module;
	
	$result=array();
	$sql = 'SELECT DISTINCT * '.
			' FROM modules m '.
			' WHERE m.index>0 '.
				' AND m.parent="" '.
				' AND m.enabled='.CMS_MODULE_ENABLED.
			' ORDER BY m.index';
//SDI($sql);
	$res = DBSELECT($sql);			
	while ($row = DBfetch($res)){
		$result[]=array('module'=>$row['module'], 
						'title'=>getword($row['module']), 
						'children'=>array(), 
						'active'=>(($row['module']==$module)?1:0));
	}
	
	$sql = 'SELECT DISTINCT * '.
			' FROM modules m '.
			' WHERE m.index>0 '.
				' AND m.parent<>"" '.
				' AND m.enabled='.CMS_MODULE_ENABLED.
			' ORDER BY m.index';
	$res = DBSELECT($sql);			
	while($row = DBfetch($res)){ //add submodules;
		foreach($result as $num => $mod){
			if ($result[$num]['module'] == $row['parent']){
				$result[$num]['children'][] = array('module'=>$row['module'], 
													'title'=>getword($row['module']), 
													'children'=>array(), 
													'active'=>0);
				break;
			}
		}
	}
	
return $result;
}

function checkmoduleindb($mdl){
	global $ln;
	
	$sql = "SELECT * FROM module_bodies WHERE module='$m' AND lang='".$ln."' limit 1";				
	$row = DBfetch(DBselect($sql));
	if (!empty($row)){
		return $row; 
	} else {
		return false;
	}
}
	
function getmoduletitle($mdl){
	return get_word($mdl);
}
	
function makesubmodulesarray($m){
	$parent = getmoduleparent($m);
	if(!$parent){
		$sql = 'SELECT DISTINCT m.* '.
				' FROM modules m'.
				' WHERE m.parent='.db_str($m).
					' AND m.enabled='.CMS_MODULE_ENABLED.
				' ORDER by m.index';
	} 
	else {
		$sql = 'SELECT DISITNCT m.* '.
				' FROM modules m '.
				' WHERE m.parent='.db_str($parent).
					' AND m.enabled='.CMS_MODULE_ENABLED.
				' ORDER by mm.index';
	}

	$result = false;
	if($res = DBselect($sql)){
		$result = array();
		while($row = DBfetch($res)){
			$result[] =  $row;
		}
	}
return $result;
}
		
function hasnoparent($mdl){
	$sql = 'SELECT parent FROM modules WHERE module='.db_str($mdl);

	if($res = DBselect($sql)){
		$row = DBfetch($res);
		if(!empty($row['parent'])){
			return false;
		}
	}
return true;
}

function gotofirstsubmodule($mdl){
	global $ln, $config;
	
	$sql = 'SELECT m.* '.
			' FROM modules m '.
			' WHERE m.parent='.db_str($m).
			' ORDER by m.index';

	if($res = DBselect($sql)){
		$row = DBfetch($res);
		$module = $row['module'];
		
		header('Location: '.$CONF['base'].'/'.$ln.'/'.$module);
	}
}
?>