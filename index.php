<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

require_once('conf/config.php');

$metakeywords		= '';
$metadescription	= '';

if (($_SERVER['REQUEST_URI'][strlen($_SERVER['REQUEST_URI'])-1]=='/')&&(strlen($_SERVER['REQUEST_URI'])>1)){ //dirty little bugfix
	header('Location: '.$CONF['base'].substr($_SERVER['REQUEST_URI'], 0, strlen($_SERVER['REQUEST_URI'])-1));
}

//ob_flush();
setLang();
cmodule::init();
$modules = cmodule::getModules(CMS_MODULE_ENABLED);

if(isset($_REQUEST['module']) && isset($modules[$_REQUEST['module']])){
	$module		= $_REQUEST['module'];
	$db_module	= $modules[$_REQUEST['module']];	
} 
elseif (isset($_REQUEST['module']))  // redirect fix for incorrect module 
	header('Location: '.$CONF['base'].'/'.$ln); 
else
{
	$module		= $CONF['default'];
	$db_module	= $modules[$module];
}
	

$action		= get_request('action', null, T_STR);
$parent		= cmodule::getParent($module);
$mtitleraw	= getword($module);
$mtitle		= getword($module);
$menu		= cmodule::getMenu(true, 'topmenu');

//$submodules = cmodule::getSubModulesArray($module);

$outline = cmodule::getOutline($module);

$index_tpl=new xTemplate(SITE_TPL_DIR . '/' . $outline);
$index_tpl->assign('mtitle', $mtitle);
if(isset($modules[$module]) || isset($submodules[$module])){
	$index_tpl->assign('module', $module);
    if(file_exists(SITE_MOD_DIR . $module.'.php')){
        require_once(SITE_MOD_DIR . $module.'.php');
		if (isset($tpl)){
			$tpl->assign('mtitle', $mtitle);
			$tpl->parse('main');			
			$index_tpl->assign('content', $tpl->text());
		}
    } else {
        $row = cmodule::getBodyByID($module, $ln);
		if($row){
			$m = cmodule::getMetaByID($module, $ln);
			if ($m){
				$metakeywords .= $m['meta_keywords'];
				$metadescription .= $m['meta_description'];
			}		
            if(!cms_empty($row['body'])){
				$content_tpl = new xTemplate(SITE_TPL_DIR . '/textarea.html');
                $content_tpl->assign('text', $row['body']);
			 	$content_tpl->assign('mtitle', $mtitle);
				$content_tpl->parse('main');
				$index_tpl->assign('content', $content_tpl->text());               				
             //   $index_tpl->assign('location', $db_module['title']);
            } else {
                if(cmodule::noParent($module)){
                    cmodule::toFirstSubModule($module);
                }
            }
        } else {
            if(cmodule::noParent($module)){
                cmodule::toFirstSubModule($module);
            }
        }
    }
	$index_tpl->assign('mtitleraw', $mtitleraw);
} else {
    $db_module=cmodule::getByID('main');	
    require_once SITE_MOD_DIR . $module.'.php';
}

foreach ($menu as $item)
{
	$index_tpl->assign('moduletitle',		$item['title']);
	$index_tpl->assign('moduledescription',	$item['description']);
	$index_tpl->assign('moduleid',			$item['module']);	
	$index_tpl->assign('menuclass',			($module === $item['module'] ? 'current' : ''));	
	$index_tpl->assign('modulehref',		$CONF['base'] . '/' . $item['module']);
	//&&(($item['module']==$parent)||($item['module']==$module))
	if (count($item['children']) > 0)
	{		
		$index_tpl->assign('moduleclick', 'javascript: return false;');
		foreach ($item['children'] as $submodule)
		{		
			$index_tpl->assign('submoduleid',		$submodule['module']);
			$index_tpl->assign('submoduletitle',	$submodule['title']);	
			$index_tpl->assign('submoduleclass',	($module === $submodule['module'] ? 'active_sub' : ''));
			
			if (isset($submodule['children']) && (count($submodule['children']) > 0))
			{
				$index_tpl->assign('submoduleclick', 'javascript: return false;');
				foreach ($submodule['children'] as $subsubmodule)
				{					
					$index_tpl->assign('subsubmoduleid', 	$subsubmodule['module']);
					$index_tpl->assign('subsubmoduletitle',	$subsubmodule['title']);					
					$index_tpl->parse('main.menu.menuitem.submenu.submenuitem.subsubmenu.subsubmenuitem');
				}
				$index_tpl->parse('main.menu.menuitem.submenu.submenuitem.subsubmenu');
			} 
			else 
				$index_tpl->assign('submoduleclick', '');			
			
			$index_tpl->parse('main.menu.menuitem.submenu.submenuitem');
			
			/*if (($parent==$item['module'])||($module==$item['module'])){				
				$index_tpl->parse('main.submenu2item');
			}*/
		}
		$index_tpl->parse('main.menu.menuitem.submenu');
		//$index_tpl->assign('modulehref',"javascript: switchState('".$item['module']."_hid'); return false;");
	//} else {
	//	$index_tpl->assign('modulehref',$CONF['base'].'/'.$item['module']);
	} 
	else {
		$index_tpl->assign('moduleclick', '');
	}
	$index_tpl->parse('main.menu.menuitem');
	//$index_tpl->parse('main.menu2.menuitem2');
}

//if ($parent){
	/*if (($parent=='topmenu')||($parent=='footer')){
		$submenu2 = cmodule::getMenu(true, $module);
	} else {
		$submenu2 = cmodule::getMenu(true, $parent);
	}*/
	
	/*if ($submenu2)
	{
		foreach ($submenu2 as $submodule){
			$index_tpl->assign('submoduleid', $submodule['module']);
			$index_tpl->assign('submoduletitle', $submodule['title']);
			
			if ($module==$submodule['module']){						
				$index_tpl->assign('submoduleclass', 'active_sub');
			} else {
				$index_tpl->assign('submoduleclass', '');
			}
			$index_tpl->parse('main.submenu2item');
		}
	}*/
//}

$index_tpl->parse('main.menu');
//$index_tpl->parse('main.menu2');

$index_tpl->assign('time',				time());
$index_tpl->assign('sitetitle',			$CONF['title'] . ' - ' . $mtitle);
$index_tpl->assign($ln.'_active',		'active');
$index_tpl->assign('metakeywords',		$metakeywords);
$index_tpl->assign('metadescription',	$metadescription);
$index_tpl->assign('pagetitle',			$mtitleraw);
//$index_tpl->assign($ln . '_active', 	'active');
$index_tpl->parse('main');

echo parselangs($index_tpl->text());

ob_end_flush();
exit;
?>