<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
	
	require_once('../conf/config.php');
	require_once('./admin.inc.php');

	setLang();
	
	session_start();

	mysql_set_charset('utf8'); 
	
	$tpl = new xTemplate(ADMIN_TPL_DIR . '/outline.html');
	
	cmodule::init();	
	
	$modules=cmodule::getModules();
	
	//$_SESSION['auth']='1';
	//debug($_SESSION);
	//SDI($_REQUEST);
	if(!isset($_SESSION['auth'])){
		$module='auth';
	} else {
		$module = get_request('module','modules');
	}	
	
	if(isset($_REQUEST['action'])){
		DBstart();
		switch($_REQUEST['action']){
			
			
			
			case "saveword":
				$word = get_request('word',array());
				$_REQUEST['lang']=$word['lang'];
				$result = saveWord($word);
				$module = 'words';
			break;
			case "deleteword":
				$wordid = get_request('wordid',0, T_ID);
				$result = deleteWords($wordid);				
				$module = 'words';
			break;
		
			case "deletefile":
				$path = get_request('path','');
				$file = get_request('file','');
				
				deletefile($path."/".$file);
				$module="uploads";
			break;
			case "auth":			
				$login = get_request('login','');
				$pass = get_request('pass','');
				if(($login == $CONF['adm_login']) && ($pass == $CONF['adm_pass'])){
					$_SESSION['auth']=1;
					$module = 'modules';
				}				
			break;
		}
		DBend();
	}
//----------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
$modules=cmodule::tieModules(cmodule::getModules());

	switch ($module){	
		case "modules":
			$tpl->assign('navclass1', 'current');
			$tpl->assign('navclass2', 'select');
			$tpl->assign('navclass3', 'select');
			$tpl->assign('navclass4', 'select');	
			
			require_once('modules/modules.php');
			
		break;
		
		case "uploads":
			$tpl->assign('navclass1', 'select');
			$tpl->assign('navclass2', 'current');
			$tpl->assign('navclass3', 'select');			
			$tpl->assign('navclass4', 'select');
			
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . '/uploads.tpl');
			if(!isset($_REQUEST['path'])){
				$path = $CONF['location'].'uploads';
			} else {
				$path = $_REQUEST['path'];
			}			
			$tmp = explode('/', $path);

			if($tmp[(sizeof($tmp))-1]=='..'){				
				$path='';
				if($tmp[sizeof($tmp)-2]!='.db_str(uploads).'){					
					for($i=0; $i<sizeof($tmp)-2; $i++){
						if(!cms_empty($tmp[$i])){
							$path.='/'.$tmp[$i];
						}
					}
				} 
				else {
					for ($i=0; $i<sizeof($tmp)-1; $i++){
						if(!cms_empty($tmp[$i])){
							$path.='/'.$tmp[$i];
						}
					}
				}
			}
			
			$content_tpl->assign('path', $path);
			$files = getfoldercontent($path);	
			
			usort($files, 'comparefiles');

			foreach($files as $key=>$val){
				if ($val['title']=='.')
					continue;
//				$content_tpl->assign('filename', $val['title']);

				$content_tpl->assign('file', $val['title']);
				if($val['type']=='d'){
					$content_tpl->assign('href', '<a href=\'javascript: pathsubmit("'.$val['title'].'");\'  style="color: #0006ff;"> '.$val['title'].'</a>');
				} else {
					$content_tpl->assign('href', $val['title']);
				}
				
				
				$content_tpl->assign('size', $val['size'].' bytes');
				
				$content_tpl->assign('delete', 
					'<form method="post">
						<input type="hidden" name="action" value="deletefile">
						<input type="hidden" name="path" value="'.$path.'">
						<input type="hidden" name="file" value="'.$val['title'].'">
						<input type="submit" value="Delete" onClick="javascript: if (!confirm(\'Are You sure?\')){ return false; }">
					</form>'
				);	
				
				
				if(($val['title']!='..')&&($val['title']!='.')){
					$content_tpl->parse('main.table.row.erase');
				}
				
				$content_tpl->parse('main.table.row');
			}
			$content_tpl->parse('main.table');
		break;
		case "uploadfile":
			$path = $_REQUEST['path'];				
			$target_path=$path."/";			
			$target_path = $target_path . basename( $_FILES['filename']['name']); 
			
			if(move_uploaded_file($_FILES['filename']['tmp_name'], $target_path)) {

			} else{
		
			} 
			echo '<form action="index.php?module=uploads" name="frm" method="post">
						<input type="hidden" name="path" value="'.$path.'">
					</form>
					<script>
						document.frm.submit();
					</script>
					</body>
					</html>';
		break;
		case "makedir":
			$path=$_REQUEST['path'];
			$filename = $_REQUEST['filename'];
			
			if($filename){
				mkdir($path."/".$filename, '0777');				
			}
			header('Location: '.$CONF['base'].'/adm/index.php?module=uploads');			
		break;
		case "words":
			$tpl->assign('navclass1', 'select');
			$tpl->assign('navclass2', 'select');
			$tpl->assign('navclass3', 'current');			
			$tpl->assign('navclass4', 'select');
			
			$content_tpl= new xTemplate(ADMIN_TPL_DIR . '/words.tpl');
			if(!isset($_REQUEST['lang'])){
				$lang = $CONF['languages']['0'];
			} 
			else {
				$lang = $_REQUEST['lang'];
			}
			$content_tpl->assign('langoptions', make_lang_options($lang));
			
			$words = getFullWords($lang);
			foreach($words as $id => $word){
				$content_tpl->insert_loop('main.table.row', $word);
			}
			
			$content_tpl->assign('lang', $lang);	
			$content_tpl->parse('main.table');		
		break;
		case "gallery":
			$tpl->assign('navclass1', 'select');
			$tpl->assign('navclass2', 'select');			
			$tpl->assign('navclass3', 'select');
			$tpl->assign('navclass4', 'current');
			require_once('modules/galleries.php');		
		break;			
		case "nooks":
			$tpl->assign('navclass1', 'select');
			$tpl->assign('navclass2', 'select');
			$tpl->assign('navclass3', 'select');
			$tpl->assign('navclass4', 'select');
			$tpl->assign('navclass5', 'current');
			$tpl->assign('navclass6', 'select');
			require_once $CONF['location'].'adm/modules/nook.php';			
		break;		
		case "auth":
			$tpl= new xTemplate(ADMIN_TPL_DIR . '/auth.tpl');
		break;
		case "exit":
			unset($_SESSION['auth']);
			header('Location: '.$CONF['base'].'/adm/index.php');
		break;
	}

	$tpl->assign('adminmodule', $module);
	if ($content_tpl) $content_tpl->assign('adminmodule', $module);
	
	if($module!="auth"){
		$content_tpl->assign('module', $module); // new style
		$content_tpl->assign('currentmodule', $module); // old
		$content_tpl->parse('main');		
		$tpl->assign('content', $content_tpl->text());	
	}
	
	$tpl->parse('main');

	echo parselangs($tpl->text(), false);	
	exit;
?>