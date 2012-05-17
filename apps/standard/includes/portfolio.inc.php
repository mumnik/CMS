<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

function getPortfolioByIDs($portfolioids, $active=null){
	cms_value2array($portfolioids);

	$portfolios = array();	
	$new_portfolioids = array();
	
	$sql_where = '';
	if(!is_null($active)){
		$sql_where.=' AND p.active='.CMS_PF_ENABLED;
	}

	$sql = ' SELECT p.* '.
			' FROM portfolios p '.
			' WHERE '.DBcondition('p.portfolioid', $portfolioids).
				$sql_where.
			' ORDER BY p.index, p.surname';
	$res = DBselect($sql);
	while($portfolio = DBfetch($res)){
		$portfolio['images'] = array();
		$portfolio['comments'] = array();
		
		$new_portfolioids[$portfolio['portfolioid']] = $portfolio['portfolioid'];
		$portfolios[$portfolio['portfolioid']] = $portfolio;
	}
	
	$comments = getCommentsByPortfolioIDs($new_portfolioids);
	foreach($comments as $commentid => $comment){
		$portfolios[$comment['portfolioid']]['comments'][$comment['lang']] = $comment;
	}

	$images = getImagesByPortfolioId($new_portfolioids, true);
	foreach($images as $imageid => $image){
		if($image['main']){
			if(!isset($portfolios[$image['portfolioid']]['main_image']))
				$portfolios[$image['portfolioid']]['main_image'] = $image;
			else
				$portfolios[$image['portfolioid']]['page_image'] = $image;
		}

//		if($image['index'] > 0)
			$portfolios[$image['portfolioid']]['images'][$image['imageid']] = $image;
	}

return $portfolios;
}

function getPortfoliosByType($type=null, $model=null, $active=null){
	$portfolioids = array();
		
	$sql_where = '';
	if(!is_null($type)){
		$sql_where.=' AND p.type='.$type;
	}
	
	if(!is_null($model)){
		$sql_where.=' AND p.model='.$model;
	}
	
	if(!is_null($active)){
		$sql_where.=' AND p.active='.$active;
	}
	
	$sql = ' SELECT p.portfolioid '.
			' FROM portfolios p '.
			' WHERE p.portfolioid>0 '.
				$sql_where.
			' ORDER BY p.index, p.surname';
			
	$res = DBselect($sql);
	while($portfolio = DBfetch($res)){
		$portfolioids[$portfolio['portfolioid']] = $portfolio['portfolioid'];
	}

	$portfolios = getPortfolioByIDs($portfolioids, $active);

return $portfolios;
}

function searchPortfolio($search){

	foreach ($search as $key=>$val){
		if ($search[$key]==''){
			unset($search[$key]);
			continue;
		}
		if (!is_array($val)){
			$search[$key]=array($val);
		}
	}

	$portfolioids = array();

	$def_params = array(
		'type' =>			array('search' => '=',		'value' => CMS_PF_TYPE_MODEL, 'type'=>T_INT, 'field' => null),
		'model' =>			array('search' => '=',		'value' => null, 'type'=>T_INT, 'field' => null),
		'name' =>			array('search' => 'LIKE',	'value' => null, 'type'=>T_STR, 'field' => null),
		'surname' =>		array('search' => 'LIKE',	'value' => null, 'type'=>T_STR, 'field' => null),
		'waist_from' =>		array('search' => '>=',		'value' => null, 'type'=>T_INT, 'field' => 'waist'),
		'waist_to' =>		array('search' => '<=',		'value' => null, 'type'=>T_INT, 'field' => 'waist'),
		'bust_from' =>		array('search' => '>=',		'value' => null, 'type'=>T_INT, 'field' => 'bust'),
		'bust_to' =>		array('search' => '<=',		'value' => null, 'type'=>T_INT, 'field' => 'bust'),
		'hips_from'=>		array('search' => '>=',		'value' => null, 'type'=>T_INT, 'field' => 'hips'),
		'hips_to' =>		array('search' => '<=',		'value' => null, 'type'=>T_INT, 'field' => 'hips'),
		'height_from' =>	array('search' => '>=',		'value' => null, 'type'=>T_INT, 'field' => 'height'),
		'height_till' =>	array('search' => '<=',		'value' => null, 'type'=>T_INT, 'field' => 'height'),
		'color_hair' =>		array('search' => 'LIKE',	'value' => null, 'type'=>T_STR, 'field' => null),
		'color_eyes' =>		array('search' => 'LIKE',	'value' => null, 'type'=>T_STR, 'field' => null),
		'langs' =>			array('search' => 'LIKE',	'value' => null, 'type'=>T_STR, 'field' => null),
		'tags' =>			array('search' => 'LIKE',	'value' => null, 'type'=>T_STR, 'field' => null),
// Photographer
		'genre' =>			array('search' => '=',		'value' => null, 'type'=>T_STR, 'field' => null),
	);

	//$sql_search = array();
	$sql_where = '';
	foreach($def_params as $field => $rule){
		if(isset($search[$field]) && !cms_empty($search[$field])){
			 $rule['value'] = $search[$field];
		} else {
			continue;
		}
		
		if (!is_null($rule['field'])){
			$field=$rule['field'];
		}
		
		if ($sql_where!=''){
			$sql_where.=' and ';
		}
					
		$sql_where.=' ( ';
		//debug($rule);
		$t=false;	
		foreach ($rule['value'] as $key=>$val){			
			
			if ($t){
				$sql_where.=' or ';
			}
			
			if($rule['search'] == 'LIKE')
			$sql_where.=  'p.'.$field.' '.$rule['search'].' ('.db_str('%'.$val.'%').') ';
		else if($rule['type'] == T_STR)
			$sql_where.=  'p.'.$field.' '.$rule['search'].' '.db_str($val);
		else if($rule['type'] == T_INT)
			$sql_where.=  'p.'.$field.' '.$rule['search'].' '.$val;
			
		//	$sql_where.= 'p.'.$field.'= "'.$val.'" '; 
			$t=true;		
		}		
		
		$sql_where.=' ) ';
		
	}
	
	$sql = 'SELECT p.portfolioid '.
			' FROM portfolios p '.
			' WHERE '.$sql_where.
			' ORDER BY p.index, p.name ';

	
	//debug($search);
	//debug($_POST);
	//echo $sql;

	$res = DBselect($sql);
	while($portfolio = DBfetch($res)){
		$portfolioids[$portfolio['portfolioid']] = $portfolio['portfolioid'];
	}

	$portfolios = getPortfolioByIDs($portfolioids, true);

	return $portfolios;
}

function savePortfolio($model, $portfolioid=0){
	$db_fields = array(
			'portfolioid' =>array('type'=>T_INT, 'value'=>$portfolioid),
			'active' =>		array('type'=>T_INT, 'value'=>0),
			'type' =>		array('type'=>T_INT, 'value'=>1),
			'model' =>		array('type'=>T_INT, 'value'=>0),
			'name' =>		array('type'=>T_STR, 'value'=>''),
			'surname' =>	array('type'=>T_STR, 'value'=>''),
			'birth_date' =>	array('type'=>T_STR, 'value'=>''),
			'height' =>		array('type'=>T_INT, 'value'=>0),
			'weight' =>		array('type'=>T_INT, 'value'=>0),
			'bust' =>		array('type'=>T_INT, 'value'=>0),
			'waist' =>		array('type'=>T_INT, 'value'=>0),
			'hips' =>		array('type'=>T_INT, 'value'=>0),
			'size_shoe' =>	array('type'=>T_INT, 'value'=>0),
			'color_eyes' =>	array('type'=>T_STR, 'value'=>''),
			'color_hair' =>	array('type'=>T_STR, 'value'=>''),
			'langs' =>		array('type'=>T_STR, 'value'=>''),
			'country' =>	array('type'=>T_STR, 'value'=>''),
			'city' =>		array('type'=>T_STR, 'value'=>''),
			'phone' =>		array('type'=>T_STR, 'value'=>''),
			'email' =>		array('type'=>T_STR, 'value'=>''),
			'tags' =>		array('type'=>T_STR, 'value'=>''),
			'genre' =>		array('type'=>T_STR, 'value'=>''),
			'url' =>		array('type'=>T_STR, 'value'=>''),
			'tourne' =>		array('type'=>T_INT, 'value'=>0),
			'index' =>		array('type'=>T_INT, 'value'=>0),
			'portfolio_file'=> array('type'=>T_STR, 'value'=>'')
			);
			
// UPDATE
	if($portfolioid > 0){
		$sql = DBprepare_update('portfolioid', $portfolioid, 'portfolios', $db_fields, $model);
	}
// INSERT
	else{
		$portfolioid = $model['portfolioid'] = get_dbid('portfolios', 'portfolioid');
		$sql = DBprepare_insert('portfolios', $db_fields, $model);
	}

	$result = DBexecute($sql);
	
return $result?$portfolioid:false;
}

function saveTeam($model, $portfolioid=0){
	$db_fields = array(
			'portfolioid' =>array('type'=>T_INT, 'value'=>$portfolioid),
			'active' =>		array('type'=>T_INT, 'value'=>0),
			'model' =>		array('type'=>T_INT, 'value'=>CMS_PF_MODEL_BECOME),
			'type' =>		array('type'=>T_INT, 'value'=>1),
			'name' =>		array('type'=>T_STR, 'value'=>''),
			'surname' =>	array('type'=>T_STR, 'value'=>''),
			'phone' =>		array('type'=>T_STR, 'value'=>''),
			'email' =>		array('type'=>T_STR, 'value'=>''),
			'note' =>		array('type'=>T_STR, 'value'=>''),
			'note2' =>		array('type'=>T_STR, 'value'=>''),
			'index' =>		array('type'=>T_INT, 'value'=>0),
			'skype' =>		array('type'=>T_STR, 'value'=>''),
			'linkedin' =>		array('type'=>T_STR, 'value'=>''),
			'role' =>		array('type'=>T_STR, 'value'=>'')			
			);
			
// UPDATE
	if($portfolioid > 0){
		$sql = DBprepare_update('portfolioid', $portfolioid, 'portfolios', $db_fields, $model);
	}
// INSERT
	else{
		$portfolioid = $model['portfolioid'] = get_dbid('portfolios', 'portfolioid');
		$sql = DBprepare_insert('portfolios', $db_fields, $model);
	}

	$result = DBexecute($sql);
	
return $result?$portfolioid:false;
}


function setCasting($portfolioid,$state){
	$db_fields = array('state' =>		array('type'=>T_INT, 'value'=>0));
	$model = array('state'=>$state);

	$sql = DBprepare_update('portfolioid', $portfolioid, 'portfolios', $db_fields, $model);
	$result = DBexecute($sql);

return $result?$portfolioid:false;
}

function saveAttachment($tmp_name){
	global $CONF;

	$file_name = time().'.pdf';
	$target_path = $CONF['location'].'attachments/';

	$target_path = $target_path.$file_name;
	$result = move_uploaded_file($tmp_name, $target_path);

return $result?$file_name:false;
}

function deleteAttachment($portfolioids){
	global $CONF;
	cms_value2array($portfolioids);

	$portfolios = getPortfolioByIDs($portfolioids);
	foreach($portfolios as $portfolioid => $portfolio){
		unlink($CONF['location'].'attachments/'.$portfolio['portfolio_file']);
	}


	$db_fields = array('portfolio_file' =>	array('type'=>T_STR, 'value'=>''));
	$portfolio = array('portfolio_file' => '');

	$sql = DBprepare_update('portfolioid', $portfolioids, 'portfolios', $db_fields, $portfolio);
	$result = DBexecute($sql);

return $result;
}

function deletePortfolio($portfolioids){
	cms_value2array($portfolioids);
	
	deleteImagesByPortfolioIDs($portfolioids);
	//deleteCommentsByPortfolioIDs($portfolioids);
	$sql = 'DELETE FROM portfolios WHERE '.DBcondition('portfolioid',$portfolioids);
	
	$result = DBexecute($sql);
return $result;
}

function set_portfolio_status($portfolioid, $active=0){
	$sql = 'UPDATE portfolios SET active='.($active?1:0).' WHERE portfolioid='.$portfolioid;
	
	$result = DBexecute($sql);
return $result;
}


function getPortfolioType($portfolioid){
	$sql = 'select type from portfolios where portfolioid="'.$portfolioid.'"';
	$res = DBselect($sql);
	if ($res){
		$row = DBfetch($res);
		return $row['type'];
	} else {
		return false;
	}
}


//---- MODEL SPECS ------

function getTypeByNum($num){
	$type = 'unknown';
	switch($num){
		case CMS_PF_MODEL_WOMEN:
			$type = 'women';
			break;
		case CMS_PF_MODEL_WOMEN_NEW:
			$type = 'women_new_face';
			break;
		case CMS_PF_MODEL_MEN:
			$type = 'men';
			break;
		case CMS_PF_MODEL_MEN_NEW:
			$type = 'men_new_face';
			break;
		case CMS_PF_MODEL_BECOME:
			$type = 'become_a_model';
			break;
	}
return $type;
}
?>