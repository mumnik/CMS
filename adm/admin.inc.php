<?php
function make_news_type_options($t=''){
	if(cms_empty($t)){
		$result = '<option value="standart" selected>Standart</option>'.
				'<option value="studiosession">Studiosession</option>';
	} 
	else {
		$result = '<option value="standart">Standart</option>'.
				'<option value="studiosession" selected>Studiosession</option>';
	}
return $result;
}

function make_outline_selector_options($cur=false){
global $CONF;
	$result='
		<option value="'.$CONF['defaultoutline'].'">Default</option>
	';
	for ($i=0; $i<sizeof($CONF['outlines']); $i++){
		if ($cur==$CONF['outlines'][$i]){
			$f = 'selected';
		} else {
			$f = '';
		}
		$result.='<option value="'.$CONF['outlines'][$i].'" '.$f.'>'.$CONF['outlines'][$i].'</option>';
	}
	return $result;
}

function make_partners_cat_options($o=''){
	$result='<option value="">None</option>';
	
	$sql='SELECT * FROM partners_categories';
	$res = DBselect($sql);
	while($row = DBfetch($res)){
		$selected=($row['id']==$o)?'selected="selected"':'';
		
		$result.='<option value="'.$row['id'].'" '.$selected.'>'.$row['id'].'</option>';
	}
return $result;
}


function getfoldercontent($path){
	$content = array();
	
//put here your own folder e.g. opendir('c:\\temp')
	if($handle = opendir($path)){
		while(false !== ($file = readdir($handle))){
//				if($file != "." && $file != "..")
//			{
//	echo is_dir($path."/".$file);
//				if($file=='..'){
//					array_push($content,array('title'=>$file, 'type'=>"d"));
//				} 
//				else {
					array_push($content,array('title'=>$file, 'size'=>filesize($path.'/'.$file), 'type'=>(is_dir($path."/".$file)?"d":"f")));
//				}
	//		}
		}
	}
return $content;
}

function deletedirectory($dirname) {
	if(is_dir($dirname))
	$dir_handle = opendir($dirname);
	
	if(!$dir_handle){
		return false;
	}
	
	while($file = readdir($dir_handle)) {
		if($file != "." && $file != "..") {
			if(!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
		else
			delete_directory($dirname.'/'.$file);
		}
	}
	
	closedir($dir_handle);
	rmdir($dirname);
return true;
} 

function deletefile($file){
	if(!is_dir($file)){
		 unlink($file);
	} else {
		deletedirectory($file);
	}
}

function makegalleryselector(){
	global $CONF;
	
	$result = array();
	
	$sql = 'SELECT * FROM galleries';
	$res = DBselect($sql);
	while($row = DBfetch($res)){
		$result[]=$row;
	}
	if(sizeof($result)>0){
		return $result;
	} 
	else {
		return false;
	}
}

function makevideogalleryselector(){
	global $CONF;
	
	$result = array();
	
	$sql = 'SELECT * FROM videogalleries';
	$res = DBselect($sql);
	while($row = DBfetch($res)){
		$result[]=$row;
	}
	if(count($result)>0){
		return $result;
	} 
	else {
		return false;
	}
}

/*
function makelangoptions($lang=''){
	if(($lang=='')||($lang=='.db_str(lv).')){
		$result='
			<option value="lv" selected>Latvian</option>
			<option value="ru">Russian</option>
		';
	} 
	else {
		$result='
			<option value="lv" >Latvian</option>
			<option value="ru" selected>Russian</option>
		';
	}
return $result;
}
*/

function walkModuleBranch($data, $level=array())
{

	makeModuleTableRow($data, $level);
	$level[]=$data['module'].'_mdl';
	
	if (count($data['children']))
		foreach ($data['children'] as $key=>$val)
			walkModuleBranch($val, $level);	
			
}


function makeModuleTableRow($data=false, $level=array()){
global $content_tpl, $CONF;
	$data['modulemargin'] = 0;
	$c = count($level);
	
	for ($i=0; $i<$c; $i++)
		$data['modulemargin']=$data['modulemargin']+25;
	
	$data['modulemargin'] = 'margin-left: '.$data['modulemargin'].'px;';
	
	if ($c)
		$data['rowstyle'] = 'display:none';
	else 
		$data['rowstyle'] = '';
	
	$data['rowclass'] = implode(' ', $level);
	$data['outline'] = make_outline_selector_options(cmodule::getOutline($data['module']));				
	$data['parent'] = makeparentoptions($data['parent'], $data['module']);
	$data['moduleclass'] = 'rootmodule';
	
	$data['editmodulelang'] = $CONF['languages'][0];
	
	if($data['enabled'] == CMS_MODULE_ENABLED)
		$data['checked']="checked";
	 else 
		$data['checked']='';	
	
	if ($data['index']==1)
	{
		$data['movedowndisabled']='disabled';
		$data['moveupdisabled']='';
		$data['vischecked']='';
	} 
	elseif ($data['index']=='0'){				
		$data['movedowndisabled']='disabled';
		$data['moveupdisabled']='disabled';
		$data['vischecked']='checked="checked"';
	} 
	else {
		$data['moveupdisabled']='';
		$data['movedowndisabled']='';
		$data['vischecked']='';
	}
	
	foreach ($data as $k=>$v)
		$content_tpl->assign($k, $v);
		
	if (count($data['children']))
		$content_tpl->parse('main.table.row.childrencontrols');
		
	$content_tpl->parse('main.table.row');		
	
}

function makeparentoptions($option='', $self=null){
	global $CONF;
	
	$result='<option value="">-</option>';
	
	$sql = 'SELECT m.module, m.parent, w.string, w.data, w.lang '.
			' FROM modules m, words w '.
			' WHERE m.title=w.string '.
				' AND w.lang='.db_str($CONF['languages'][0]).
			' GROUP by m.module'.
			' ORDER BY w.string'
			;
	$res = DBselect($sql);	

	while($val = DBfetch($res)){
		if ($val['module']==$self) continue;
		$selected=($val['module']==$option)?'selected="selected"':'';		
		$result.='<option value="'.$val['module'].'" '.$selected.'>'.$val['data'].'</option>';
	}
return $result;
}
?>