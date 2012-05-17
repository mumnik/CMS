<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
class CModule {

public static $inited=false;
public static $modules=array();

	public static function init(){
		self::$inited = true;
		
		$sql = 'SELECT DISTINCT m.* '.
				' FROM modules m '.
				' ORDER BY m.module, m.index';
		$res = DBselect($sql);
		while($module=DBfetch($res)){
			$module['title'] = getword($module['title']);
			self::$modules[$module['module']] = $module;
		}
	}
	
	/*public static function moveup($id){
		$parent = self::getParent($id);
		$arr = self::getModules(null, $parent['module']);
		if ($arr){
			unset($arr[$parent['module']]);
		}
		if ($arr[$id]['index']>0){
			$arr[$id]['index']--;
			foreach ($arr as $m=>$v){
				if (($v['index']==$arr[$id]['index'])&&($m!=$id)){
					self::setIndex($m, ($v['index']+1));
				}
			}
			self::setIndex($id, $arr[$id]['index']);
		}		
	}*/
	
	/*public static function untieModuleMenu($id){
		self::setIndex($id, 0);
	}*/
	
	/*public static function tieModuleMenu($id){
		$parent = self::getParent($id);
		self::setIndex($id, self::getMaxIndexByParentID($parent['module']));
	}*/
	
	/*public static function movedown($id){
		$mod = self::getByID($id);
		
		if ($mod['index']<2){
			return false;
		}
		
		$parent = self::getParent($id);
		$arr = self::getModules(null, $parent);
		if ($arr){
			unset($arr[$parent['module']]);
		}
		
			$arr[$id]['index']++;
			foreach ($arr as $m=>$v){
				if (($v['index']==$arr[$id]['index'])&&($m!=$id)){
					self::setIndex($m, ($v['index']-1));
				}
			}
			self::setIndex($id, $arr[$id]['index']);				
	}*/
	
	/*private static function setIndex($id, $index){
		$sql = 'update modules set `index`="' . $index.'" where module="' . $id . '"';
		DBexecute($sql);
	}*/
		
	public static function getByID($id, $enabled=null)
	{
		global $CONF;
		
		$sql_where = '';
		
		if(!is_null($enabled))		
			$sql_where .= ' AND m.enabled=' . $enabled;		
		
		$sql = ''.
			' SELECT DISTINCT m.* '.
			' FROM modules m '.
			' WHERE m.module='.db_str($id).
				$sql_where.
			' ORDER BY m.index';
			
		$res	= DBselect($sql);
		$module	= DBfetch($res);
		
		if($module)
		{			
			$module['title'] = getword($module['module']);			
			if ($module['outline'] === '')
				$module['outline'] = $CONF['outlines'][0];
		}
				
		return $module;
	}
	
	public static function getBodyByID($id, $lang){
		$module_body = '';

		$sql = 'SELECT mb.* '.
				' FROM module_bodies mb '.
				' WHERE mb.module='.db_str($id).
					' AND mb.lang='.db_str($lang);

		$module_body=DBfetch(DBselect($sql));
				
	return $module_body;
	}
	
	public static function getDescriptionByID($id, $lang){
		$module_description = '';

		$sql = 'SELECT md.* '.
				' FROM module_descriptions md '.
				' WHERE md.module='.db_str($id).
					' AND md.lang='.db_str($lang);

		$module_description=DBfetch(DBselect($sql));
		if ($module_description){
			$module_description=$module_description['description'];
		}
	return $module_description;
	}
	
	public static function getOutline($id)
	{
		global $CONF;
	
		$result = $CONF['defaultoutline'];
		
		$sql = 'select outline from modules where module="' . $id . '"';
		$res = DBfetch(DBselect($sql));
		
		if ($res['outline']!='')
			$result = $res['outline'];
		
		return $result;
	}	
	
	public static function setOutline($id, $outline=false)
	{
		global $CONF;
		
		if (!$outline)
			$outline = $CONF['defaultoutline'];
		
		$sql = 'update modules set outline="' . $outline . '" where module="' . $id . '"';
		
		return DBexecute($sql);
	}
	
	public static function changeModuleId($id, $newid)
	{
		$result = true; 
		
		$sql = 'update words set string="' . $newid.'" where string="' . $id . '"';
		$result &= DBexecute($sql);
		
		$sql = 'update module_bodies set module="' . $newid . '" where module="' . $id . '"';
		$result &= DBexecute($sql);
		
		$sql = 'update module_descriptions set module="' . $newid . '" where module="' . $id . '"';
		$result &= DBexecute($sql);
				
		$sql = 'update module_meta set module="' . $newid . '" where module="' . $id . '"';
		$result &= DBexecute($sql);
		
		$sql = 'update modules set module="' . $newid . '", title="' . $newid . '" where module="' . $id . '"';
		$result &= DBexecute($sql);

		return $result;
	}
	

	
	public static function getMaxIndexByParentID($parentid){
		if (is_array($parentid))
			$parentid=$parentid['module'];
		
		if ($parentid == '')
			return false;
		
		$sql = 'select MAX(m.index) as maxindex FROM modules m WHERE m.parent = ' . db_str($parentid);
		$res = DBselect($sql);
		if ($res)
		{
			$row = DBfetch($res);
			return $row['maxindex'] + 1;
		}
		else {
			echo 'ERROR occured finding max index';
			return false;		
		}
	}
	
	public static function setParent($id, $parent=false){		
		$sql = 'update modules set parent="'.$parent.'" where module="'.$id.'"';				
		DBexecute($sql);
		//self::setIndex($id,self::getMaxIndexByParentID($parent));
	}
	
	public static function getMetaByID($id, $lang){
		$module_meta = '';

		$sql = 'SELECT md.meta_keywords, md.meta_description '.
				' FROM module_meta md '.
				' WHERE md.module='.db_str($id).
					' AND md.lang='.db_str($lang);

		$module_meta=DBfetch(DBselect($sql));
		return $module_meta;
	}
	
	public static function getModules($enabled=null, $parents=null){
	global $ln;

		$modules = array();
		
		$sql_where = '';
		if(!is_null($enabled)){
			$sql_where.= ' AND m.enabled='.$enabled;
		}
		
		if(!is_null($parents)){
			if ($parents === 'empty'){
				$parents = '';
			}
			cms_value2array($parents);
			$sql_where.= ' AND '.DBcondition('m.parent',$parents, null, true);
		}
		
		$sql = 'SELECT DISTINCT m.* '.
				' FROM modules m '.
				'  WHERE 1'.
//				' WHERE m.index>0 '.
					$sql_where.
				' ORDER BY m.parent, m.index';
		$res = DBselect($sql);
		
		while($module = DBfetch($res))
		{		
			$module['title']			= getword($module['module']);
			$module['description']		= self::getDescriptionByID($module['module'],$ln);		
			$modules[$module['module']]	= $module;
		}
		
		return $modules;
	}
	
	public static function getHiddenModules($enabled=null, $parents=null){
		$modules=array();
		
		$sql_where = '';
		if(!is_null($enabled)){
			$sql_where.= ' AND m.enabled='.$enabled;
		}
		
		if(!is_null($parents)){
			cms_value2array($parents);
			$sql_where.= ' AND '.DBcondition('m.parent',$parents, null, true);
		}
		
		$sql = 'SELECT DISTINCT m.* '.
				' FROM modules m '.
				' WHERE m.hhiden=1 '.
					$sql_where;
		$res = DBselect($sql);
		while($module=DBfetch($res)){
			$module['title'] = getword($module['title']);
			$modules[$module['module']] = $module;
		}
				
	return $modules;
	}
	

	public static function save($module, $moduleid = 0)
	{
		global $CONF;
		if ($moduleid == 0)
		{
			$sql = ''.
				' INSERT INTO '.
				'	`modules` '.
				' SET '.
				'	`parent` = ' . db_str($module['parent']) . ','.
				'	`module` = ' . db_str($module['module']) . ','.
				'	`enabled` = "1",'.
				'	`index` = ' . db_str($module['index']).				
				'';
		}
		else{
			$sql = ''.
				' UPDATE '.
				'	`modules` '.
				' SET '.
				'	`parent` = ' . db_str($module['parent']) . ','.
				'	`module` = ' . db_str($module['module']) . ','.
				'	`enabled` = "1",'.
				'	`index` = ' . db_str($module['index']).
				' WHERE '.
				'	`module` = ' . db_str($module['module']).
				'';
		}
		
		return DBexecute($sql);
		
		/*$db_fields = array(
			'moduleid' 	=> array('type' => T_INT, 'value' => $moduleid),
			'module' 	=> array('type' => T_STR, 'value' => null),
//			'title' 	=> array('type' => T_STR, 'value' => null),
			'enabled' 	=> array('type' => T_INT, 'value' => 1),
			'parent' 	=> array('type' => T_STR, 'value' => $module['parent']),
			'index' 	=> array('type' => T_INT, 'value' => 0)
		);
	// UPDATE
		if($moduleid > 0){
			$sql = DBprepare_update('module', $moduleid, 'modules', $db_fields, $module);
		}
	// INSERT
		else{
			$moduleid	= $module['moduleid'] = get_dbid('modules', 'moduleid');
			$sql 		= DBprepare_insert('modules', $db_fields, $module);
		}*/
		
		//$result = DBexecute($sql);

		//return $result ? $moduleid : false;
	}
	
	public static function relocateModule($module, $position, $parent)	
	{
		$info = self::getByID($module);
		
	//	if ($parent === $info['parent'] && $position == $position)
		//	return false;
		
		$sql = ''.
			' UPDATE '.
			'	modules m'.
			' SET '.
			'	m.index = m.index+1 '.
			' WHERE '.
			'	m.parent = "' . $parent . '" '.
			' AND '.
			'	m.index >= "' . $position . '"'.			
			'';
		var_dump($sql);
		DBexecute($sql);
		
		$sql = ''.
			' UPDATE '.
			'	modules m'.
			' SET '.
			'	m.index = "' . $position . '", '.
			'	m.parent = "' . $parent . '" '.
			' WHERE '.			
			'	m.module = "' . $module . '"'.			
			'';
		var_dump($sql);
		DBexecute($sql);
		
		$sql = ''.
			' UPDATE '.
			'	modules m'.
			' SET '.
			'	m.index = m.index-1 '.
			' WHERE '.
			'	m.parent = "' . $info['parent'] . '" '.
			' AND '.
			'	m.index >= "' . $info['index'] . '"'.
			' AND '.
			'	m.module != "' . $module . '"'.
			'';
		var_dump($sql);
		DBexecute($sql);

		return true;
	}
	
	public static function saveBody($body){		
		
		$db_fields = array(
			'module' 	=> array('type'=>T_STR, 'value'=>null),
			'body' 		=> array('type'=>T_STR, 'value'=>null),
			'lang' 		=> array('type'=>T_STR, 'value'=>null),
			'message' 	=> array('type'=>T_STR, 'value'=>null)
		);
				
		self::deleteBody($body['module'],$body['lang']);
		$sql 	= DBprepare_insert('module_bodies', $db_fields, $body);
		$result = DBexecute($sql);
		
		$sql = 'update words 
			set data="' . $body['title'] . '" 
			where string="' . $body['module'] . '" 
			and lang="' . $body['lang'] . '"';
		
	
		$result&=DBexecute($sql);
		
		return $result;
	}

	public static function setState($id, $mode){
		$sql = 'UPDATE modules '.
				'SET enabled=' . $mode.
				' WHERE module=' . db_str($id);
	
		$result = DBexecute($sql);
		
		return $result;
	}
	
	public static function delete($moduleid)
	{		
		self::deleteBody($moduleid);
		$result = DBexecute('DELETE FROM modules WHERE module = ' . db_str($moduleid));
		
		$sql = 'delete from words where string = ' . db_str($moduleid);
		$result &= DBexecute($sql);
		
		return $result;
	}
	
	public static function deleteBody($id, $lang=null){
		$sql_where = '';
		if(!is_null($lang)){
			$sql_where = ' AND lang='.db_str($lang);
		}
		
		$result = DBexecute('DELETE FROM module_bodies WHERE module='.db_str($id).$sql_where);
	return $result;
	}
	
	public static function getCurrentParent(){
		global $module;
		$result = cmodule::getParent($module);
	return $result;
	}

	public static function getParent($mdl){
		$result = false;
		
		$sql = 'SELECT parent FROM modules WHERE module='.db_str($mdl);
		$res = DBselect($sql);
		if($row = DBfetch($res)){			
			$result = self::getByID($row['parent']);
		}
	return $result;
	}

	public static function isEnabled($mdl){
		if(!self::$inited) self::init();
		
		return (bool) self::$modules[$mdl]['enabled'];
	}
		
	public static function getTitle($mdl){
		$title = $mdl;
		if(!self::$inited) self::init();
		
		$title = self::$modules[$mdl]['title'];
		
	return get_word($title);
	}
	
	public static function getIndex($mdl){
		$sql = 'SELECT m.index '.
				' FROM modules m '.
				' WHERE m.module='.db_str($mdl);
		$res = DBselect($sql);
		
		if($module = DBfetch($res))
			return $module['index'];

	return '';
	}
		
	public static function getSubModulesArray($mdl){
        $result = array();

		$parent = cmodule::getParent($mdl);

		if(!$parent){
			$sql = 'SELECT DISTINCT m.* '.
					' FROM modules m '.
					' WHERE m.parent='.db_str($mdl).
						' AND m.enabled='.CMS_MODULE_ENABLED.
					' ORDER by m.index';
		} 
		else {
			$sql = 'SELECT DISTINCT m.* '.
					' FROM modules m '.
					' WHERE m.parent='.db_str($parent['module']).
						' AND m.enabled='.CMS_MODULE_ENABLED.
					' ORDER by m.index';
		}
        
		$res = DBselect($sql);
        while($row = DBfetch($res)){
            $result[$row['module']] =  $row;
        }

	return $result;
	}
			
	public static function noParent($mdl){
		$title = $mdl;
		if(!self::$inited) self::init();
		
	return empty(self::$modules[$mdl]['parent']);
	}

	public static function toFirstSubModule($mdl){
		global $ln, $CONF;
		
		$sql = 'SELECT m.* '.
				' FROM modules m '.
				' WHERE m.parent='.db_str($mdl).
				' ORDER by m.index';

		if($res = DBselect($sql)){
			$row = DBfetch($res);
			$module = $row['module'];
			
			header('Location: '.$CONF['base'].'/'.$ln.'/'.$module);
		}
	}
	
	
	public static function tieModules($data){
		$result = array();
		foreach ($data as $key=>$val){
			if ($val['parent']==''){				
			
			} else {
				$data[$val['parent']]['children'][$key]=$val;
			}
		}
		
		foreach ($data as $key=>$val){
			if ($val['parent']==''){				
			
			} else {
				$data[$val['parent']]['children'][$key]=$val;
				unset($data[$key]);
			}
		}
		
		return $data;
	}
	
	public static function getMenu($enabledOnly=true, $parent = null)
	{		
		/*$parents	= array();
		$result		= array();
		
		if ($enabledOnly)
			$modules = self::getModules(CMS_MODULE_ENABLED, $parent);
		else
			$modules = self::getModules(null, $parent);		
		
		foreach($modules as $key => $row)
		{
			if ($row['index'] >= 0){
				$parents[$key] = $key;
				$result[] = array(
					'module'		=> $row['module'], 
					'title'			=> getword($row['title']), 
					'children'		=> array(), 
					'description'	=> $row['description']
				);								
			}
		}		
		
		$modules = self::getModules(CMS_MODULE_ENABLED , $parents);
		
		foreach($modules as $key => $row){
			foreach($result as $num => $mod)
			{
				if ($result[$num]['module'] === $row['parent'])
				{
					$result[$num]['children'][] = array(
						'module'	=> $row['module'], 
						'title'		=> $row['title'], 
						'children'	=> array(), 
						'active'	=> 0
					);
					break;
				}
			}
		}
		
	return $result;*/
		
		$modules	= self::getModules(true); 		
		$root		= self::getByID($parent);
		
		if (!$root)
		{
			echo 'Error building menu';
			return false;
		}
		
		$root['children'] = array();
		
		$result = array(
			$root['module'] => $root
		);
		
		if (count($modules))
		{				
			foreach ($modules as $mid => $data)
				if ($data['parent'] == null || !isset($modules[$mid]['parent'])) 
					$modules[$mid]['parent'] = 'root';	
			
			foreach ($modules as $mid => $data)
			{			
				$result[$mid] = isset($result[$mid]) ? array_merge($result[$mid], $data) : $data;			
				$result[$data['parent']]['children'][$mid] = $mid;
			}
		}			
		$tree = self::buildModuleTreeBranches($result[$parent], $result);
		
		return $result[$parent]['children'];
	}
	
	public static function walkModulesTree(&$tail)
	{
		$children = array();
		if (count($tail['children']))
			foreach ($tail['children'] as $child)
				$children[] = self::walkModulesTree($child);
		
		return array(
			'data' 		=> $tail['title'],
			'attr' 		=> array(
				'id' 	=> 'node_' . $tail['module'],
				'rel'	=> 'folder'				
			),
			'state'		=> count($children) ? 'open' : '',
			'children'	=> $children
		);
	}
	
	private static function buildModuleTreeBranches(&$branch, &$data)
	{		
		if (count($branch['children']))			
			foreach ($branch['children'] as $child)
				$branch['children'][$child] = self::buildModuleTreeBranches($data[$child], $data);		
		
		return $branch;
	}	
	
	public static function makeModulesTree($prefs)
	{
		$modules = self::getModules(); 
		
		$result = array( // root element. even if there will b no modules, we'll have a root
			'root' => array(
				'module'	=> 'root',
				'title'		=> 'root',
				'index'		=> '0'
			)
		);
		
		if (count($modules))
		{				
			foreach ($modules as $mid => $data)
				if ($data['parent'] == null || !isset($modules[$mid]['parent'])) 
					$modules[$mid]['parent'] = 'root';	
			
			foreach ($modules as $mid => $data)
			{			
				$result[$mid] = isset($result[$mid]) ? array_merge($result[$mid], $data) : $data;			
				$result[$data['parent']]['children'][$mid] = $mid;
			}
		}	
		
		if ($prefs['linear'])
			return $result;
			
		$tree = self::buildModuleTreeBranches($result['root'], $result);
		
		return $tree;
	}
	
}
?>