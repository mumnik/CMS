<?php

	switch ($_REQUEST['action'])
	{
		case "proccesscreatemodule":
			$moduleid 				= get_request('moduleid', 	0,	T_INT);			
			$new_module['module'] 	= get_request('newmodule',	'', T_STR); //???
			$new_module['parent']	= get_request('parent', 	'', T_STR);
			$new_module['index']	= cmodule::getMaxIndexByParentID($new_module['parent']);
			$new_module['title']	= get_request('title', 		false);
			
			cmodule::save($new_module, $moduleid);				
			
			foreach ($CONF['languages'] as $lang) // move this to words or cmodule
			{
				$sql = '
					insert into 
						words 
					set 
						string = "' . $new_module['module'] . '",
						lang="' . $lang . '",
						data="' . $new_module['title'][$lang] . '"';
				mysql_query($sql);
			}

			header('Location: index.php?module=modules'); //hack
			exit;
		break;
		case "changemodstat":
			$id		= get_request('moduleid',	false);
			$mode	= get_request('stat',		false);		

			$mode = ($mode === 'false') ? CMS_MODULE_DISABLED : CMS_MODULE_ENABLED;
			
			json_headers(
				array(
					'result' => cmodule::setState($id, $mode)
				)
			);			
		break;
		case 'getmodulestree':				
			switch(get_request('operation', false))
			{	
				case 'get_children':					
					$tree = cmodule::makeModulesTree(array('linear' => false));
					json_headers(cmodule::walkModulesTree($tree));
				break;
				case 'moveNode':
					$position	= get_request('position',	false);
					$parent		= get_request('ref',		false);
					$moduleid	= get_request('moduleid',	false);
					
					if ($position !== false && $parent !== false)
						json_headers(
							array(
								'status' => cmodule::relocateModule($moduleid, $position, $parent) ? 'OK' : 'FAILURE'
							)
						);
					else
						json_headers(
							array(
								'status' => 'FAILURE'
							)
						);
				break;
				default:
					
				break;
			}			
			exit;
		break;
		case 'getModuleInfo':
		
			$moduleid 	= get_request('moduleid', false);
			$moduleData	= cmodule::getByID($moduleid);			
				
			json_headers(
				array(
					'data' => $moduleData
				)
			);
			exit;
		break;
		case "erasemodule":
			$moduleid = get_request('moduleid', false);
			$result = cmodule::delete($moduleid);			
			json_headers(
				array(
					'status'	=> $result ? 'OK' : 'FAILURE',
					'message'	=> ($result ? 'Module erased' : 'Error occured deleting ' . $id)
				)
			);
		break;
		case "changemodvisibility":
			/*$id = get_request('moduleid', false);
			$state = get_request('state', false);
			if ($state=='on'){
				cmodule::untieModuleMenu($id);
			} else {
				cmodule::tieModuleMenu($id);
			}*/
		break;
		case "changemoduleid":
			$id = get_request('id', false);
			$newid = get_request('newid', false);
			if (($id)&&($newid)){
				cmodule::changeModuleId($id, $newid);
			}
			//header('Location: index.php?module=modules');
		break;
		case "setoutline":
			$id = get_request('id','');
			$outline = get_request('outline', false);
			cmodule::setOutline($id, $outline);
			header('Location: index.php?module=modules');
		break;
		case "editbody":
		
			$id 			= get_request('moduleid',	null, T_STR);			
			$b['module']	= $id;
			$b['lang']		= get_request('lang',		null, T_STR);
			$b['body']		= get_request('body',		null, T_STR);
			$b['title']		= get_request('title',		null, T_STR);			
			$d = get_request('description',				null, T_STR);
			$mk = get_request('meta_keywords',			null, T_STR);
			$md = get_request('meta_description',		null, T_STR);
			//change this!
			$sql = 'select count(*) from module_descriptions where module="'.$id.'" and lang="'.$b['lang'].'"';
			$count = DBfetch(DBselect($sql));
			
			if ($count['count(*)'])
			{
				$sql = 
					'
					update 
						module_descriptions 
					set 
						description="'.$d.'" 
					where 
						module="'.$id.'"
					and
						lang="'.$b['lang'].'"
					';
			} 
			else {
				$sql = 
					'
					insert into
						module_descriptions 
					set 
						description="'.$d.'",						 
						module="'.$id.'",
						lang="'.$b['lang'].'"
					';
			}

			DBexecute($sql);				
			
			$sql = 'select count(*) from module_meta where module="'.$id.'" and lang="'.$b['lang'].'"';
			$count = DBfetch(DBselect($sql));
			
			if ($count['count(*)']){
				$sql = 
					'
					update 
						module_meta 
					set 
						meta_keywords="'.mysql_escape_string($mk).'",
						meta_description="'.mysql_escape_string($md).'"
					where 
						module="'.$id.'"
					and
						lang="'.$b['lang'].'"
					';
			} else {
				$sql = 
					'
					insert into
						module_meta 
					set 
						meta_keywords="'.mysql_escape_string($mk).'",
						meta_description="'.mysql_escape_string($md).'",						 
						module="'.$id.'",
						lang="'.$b['lang'].'"
					';
			}

			DBexecute($sql);				
			
			cmodule::saveBody($b,$id);			

			$gotolang = get_request('gotolang', false);
			
			if ($gotolang)
				header('Location: index.php?module=modules&action=bodyedit&moduleid='.$id.'&lang='.$gotolang);
			else 
				$module="modules";
							
		break;
		case "editModule":		
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . "/moduleedit.html");

			$moduleid	= get_request('moduleid','');
			$lang		= get_request('lang',false);

			if (!$lang)
			   $lang = $CONF['languages'][0];
			   
			$content_tpl->assign('adminmodule', $moduleid);
			for ($i=0; $i<sizeof($CONF['languages']); $i++)
			{			
				if ($CONF['languages'][$i] == $lang)
					$content_tpl->assign('langclass', 'active');
				else 
					$content_tpl->assign('langclass', '');
				
				$content_tpl->assign('lang', $CONF['languages'][$i]);
				$content_tpl->parse('main.languages.language');
			}
			$content_tpl->parse('main.languages');
			
			$ln = $lang;		

			$mdl = cmodule::getByID($moduleid);
			
			if($body = cmodule::getBodyByID($moduleid, $lang))
				$content_tpl->assign($body);
			else
				$content_tpl->assign('module', $moduleid);							

			$content_tpl->assign('lang', $lang);
			$content_tpl->assign('description', cmodule::getDescriptionByID($moduleid, $lang));
			$meta = cmodule::getMetaByID($moduleid, $lang);
			$content_tpl->assign('meta_keywords', $meta['meta_keywords']);
			$content_tpl->assign('meta_description', $meta['meta_description']);
			
			$content_tpl->assign('moduleid', $moduleid);
			$content_tpl->assign('action', 'editbody');
			$content_tpl->assign('title', $mdl['title']);
		break;	
		case "createmodule":			

			$content_tpl = new xTemplate(ADMIN_TPL_DIR . "/createmodule.tpl");
			cmodule::init();
			
			foreach ($CONF['languages'] as $lang){
				$content_tpl->assign('lang', $lang);
				$content_tpl->parse('main.langtitles.langtitle');
			}
			$content_tpl->parse('main.langtitles');
			
			$nid = get_dbid('modules', 'moduleid');
			
			$content_tpl->assign('nid', $nid);
			
			$mods = cmodule::$modules;
			foreach($mods as $key => $val){
				$val['title'] = getword($val['module']);
				$content_tpl->insert_loop('main.mselect.option', $val);
			}
			$content_tpl->parse('main.mselect');

		break;
		default:
			$content_tpl 	= new xTemplate(ADMIN_TPL_DIR . '/modules.html');			
			$tree 			= cmodule::makeModulesTree(array('linear' => false));			
			$content_tpl->parse('main.table');
		break;
	}