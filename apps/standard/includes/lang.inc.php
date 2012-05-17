<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
function setLang($lang=''){	
	global $CONF, $ln;
			
	if(empty($lang)){
		if(isset($_GET['language'])){
			if (in_array($_GET['language'], $CONF['languages'])){
				$ln = $_GET['language'];
			} 
			else {
				$ln = $CONF['languages']['0'];
				header('Location: '.$CONF['base'].'/'.$ln); 
			} 
		} 
		else {
			$ln = $CONF['languages']['0'];
		}
	} 
	else {
		if (in_array($lang, $CONF['languages'])){
			$ln=$lang;
			redirect();
		} 
		else {
			$ln = $CONF['languages']['0'];
			redirect();
		}
	}
}

function selfURL(){ 
	if(empty($_SERVER["HTTPS"])){
		$s = '';
	}
	else{
		if($_SERVER["HTTPS"] == "on"){
			$s = 's';
		}
		else{
			$s = '';
		}
	}

	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), '/').$s; 
	$port = ($_SERVER['SERVER_PORT'] == '80')?'':(':'.$_SERVER['SERVER_PORT']); 
	
return $protocol.'://'.$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
}

function make_lang_options($op=''){
	global $CONF;
	$result='';
	
	foreach($CONF['languages'] as $key=>$val){
		if($val==$op){
			$selected=' selected="selected" ';
		} 
		else{
			$selected='';
		}
		
		$result.='<option value="'.$val.'" '.$selected.'>'.$val.'</option>'."\n";
	}
	
return $result;
}

function makemenu($arr){
	global $ln, $CONF;

	$menu = make_menu_entry($arr);

	$menu[0] = '<ul id="sample-menu-1" class="sf-menu">'."\n";

return implode($menu);
}

function make_menu_entry($menu_arr){
	global $ln, $CONF;

	$menu = array();
	$menu[] = '<ul>';
//class="'.(($entry['active']=='1')?"act-a":"dis-a").'"
	foreach($menu_arr as $num => $entry){
		$menu[] = "\t\n";
		$menu[] = '<li class="current">'."\n";	
		if ($entry['module']!='newsletter'){
			$menu[] = '<a href="'.$CONF['base'].'/'.$entry['module'].'" >';
		} else {
			$menu[] = '<a href="'.$CONF['base'].'/'.$entry['module'].'" class="zoom">';
		}


		$menu[] = $entry['title'];
		$menu[] = '</a>';

		$childs = $entry['children'];
		if(!empty($childs)){
			$menu[] = implode(make_menu_entry($childs));
		}

		$menu[] = "\n".'</li>'."\n";
	}
	$menu[] = '</ul>'."\n";

return $menu;
}

function makelangselector(){
	global $CONF, $ln, $module, $action, $index_tpl;
/*	$hrefs = "";
	$m = empty($module)?"":"/".$module;
	$a = empty($action)?"":"/".$action;
	foreach ($CONF['languages'] as $key=>$val){
		if ($ln==$val){ //highlight current language
			$selected="selected_";
		} else {
			$selected="";
		}			
		$hrefs.="
		<div class=\"lng\">
			<a class=\"links\" HREF=\"".$CONF['base']."/".$val.$m.$a."\">
				<img border=\"0\" src=\"{base}/i/".$selected.$val.".png\" width=\"41\" height=\"35\">
			</a>
		</div>";
	}
	return $hrefs;*/
	if($ln=="en"){
		$index_tpl->assign('en_class', 'eng_a');
		$index_tpl->assign('ru_class', 'rus');
		$index_tpl->assign('lv_class', 'lat');
	}
	else if($ln=="lv"){
		$index_tpl->assign('en_class', 'eng');
		$index_tpl->assign('ru_class', 'rus');
		$index_tpl->assign('lv_class', 'lat_a');
	} 
	else {
		$index_tpl->assign('en_class', 'eng');
		$index_tpl->assign('ru_class', 'rus_a');
		$index_tpl->assign('lv_class', 'lat');
	}
}


function parselangs($tpl, $links=true){
	global $CONF, $ln;
	
	$words = getCurrentWords();
	foreach($words as $key=>$val){
		$tpl=preg_replace("'<!$key>'", $val, $tpl);
	}
	
//parse all internal hrefs 	
	if($links){
		$tpl= preg_replace("'href=\"".$CONF['base']."'", "href=\"".$CONF['base']."/$ln", $tpl);
	}
	return $tpl;
}
?>