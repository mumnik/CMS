<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
function getNews($lang=null, $limitfrom=null, $limit=null, $type=null){
	global $CONF;

	$sql_where = '';
	
	if ($type){
		$sql_where='where n.type="'.$type.'"';
	}
	
	$news = array();
	$new_newsids = array();
	$sql = ' SELECT n.*, DATE_FORMAT(n.date, "%d.%m.%Y") as fdate '
			.' FROM news n '
			.$sql_where
			.' ORDER BY n.date DESC';
	if (($limitfrom)&&($limit)){
		$sql.=' limit '.$limitfrom.' , '.$limit;
	} elseif ($limit){
		$sql.=' limit '.$limit;
	} elseif ($limitfrom){
		echo 'incorrect limit params';
	}
	$res = DBselect($sql);
	//echo $sql;
	while($new = DBfetch($res)){
		$new['images'] = array();
		$new['newsbody'] = array();
		foreach($CONF['languages'] as $num => $lng){
			$new['newsbody'][$lng] = array();
		}

		$news[$new['newsid']] = $new;
		$new_newsids[$new['newsid']] = $new['newsid'];
	}

// NEWS BODY
	$newsbodies = getNewBody($new_newsids, $lang);
	foreach($newsbodies as $newsid => $body){
		$news[$newsid]['newsbody'] = $body;
	}

// IMAGES
	$images = getImagesByNewsId($new_newsids, true);
	foreach($images as $imageid => $image){
		if($image['main']){
			if(!isset($news[$image['newsid']]['main_image']))
				$news[$image['newsid']]['main_image'] = $image;
			else
				$news[$image['newsid']]['page_image'] = $image;
		}

//		if($image['index'] > 0)
			$news[$image['newsid']]['images'][$image['imageid']] = $image;
	}

	return $news;
}

function getNewsByID($newsids, $lang=null){
	global $CONF;
	
	cms_value2array($newsids);

	$sql_where = '';
//	if(!$showall){
//		$sql_where.= ' AND i.index>0 ';
//	}

	$news = array();
	$new_newsids = array();
	
	$sql = ' SELECT n.*, FROM_UNIXTIME(n.date, "%d.%m.%Y") as fdate '.
			' FROM news n '.
			' WHERE '.DBcondition('n.newsid',$newsids).
				$sql_where.
			' ORDER BY n.date DESC';
		
	$res = DBselect($sql);
	while($new = DBfetch($res)){

		$new['date']=strftime('%d.%m.%Y',strtotime($new['date']));
		$new['images'] = array();
		$new['newsbody'] = array();
		foreach($CONF['languages'] as $num => $lng){
			$new['newsbody'][$lng] = array();
		}
			
		$news[$new['newsid']] = $new;
		$new_newsids[$new['newsid']] = $new['newsid'];
	}	

// NEWS BODY
	$newsbodies = getNewBody($newsids, $lang);
	foreach($newsbodies as $newsid => $body){
		$news[$newsid]['newsbody'] = $body;
	}
	
// IMAGES
	$images = getImagesByNewsId($new_newsids, true);
	foreach($images as $imageid => $image){
		if($image['main']){
			if(!isset($news[$image['newsid']]['main_image']))
				$news[$image['newsid']]['main_image'] = $image;
			else
				$news[$image['newsid']]['page_image'] = $image;
		}

//		if($image['index'] > 0)
			$news[$image['newsid']]['images'][$image['imageid']] = $image;
	}
	
return $news;
}

function getNewBody($newsids, $lang){
	global $CONF;
	
	cms_value2array($newsids);
	
	$result = array();

	$sql_where = '';
	if(!is_null($lang))
		$sql_where = ' and lang='.db_str($lang);
		
	$sql = 'SELECT nb.* '.
			' FROM newsbody nb '.
			' WHERE '.DBcondition('nb.newsid', $newsids).
				$sql_where;
	$res = DBselect($sql);
	while($newsbody = DBfetch($res)){
		if(!isset($result[$newsbody['newsid']])){
			$result[$newsbody['newsid']] = array();
			foreach($CONF['languages'] as $num => $lang){
				$result[$newsbody['newsid']][$lang] = array();
			}
		}
		
		$result[$newsbody['newsid']][$newsbody['lang']] = $newsbody;
	}
	
return $result;
}

function saveNews($new, $newsid=0){
	$db_fields = array(
			'newsid' =>		array('type'=>T_INT, 'value'=>$newsid),
			'date' =>		array('type'=>T_STR, 'value'=>date('Y-m-d')),
			'type' =>		array('type'=>T_STR, 'value'=>'site')
			);	
		
// UPDATE
	if($newsid > 0){
		$sql = DBprepare_update('newsid', $newsid, 'news', $db_fields, $new);
	}
// INSERT
	else{
		$newsid = $new['newsid'] = get_dbid('news', 'newsid');
		$sql = DBprepare_insert('news', $db_fields, $new);
	}

	$result = DBexecute($sql);	
	if($result){
		deleteNewsBody($newsid, $new['lang']);
		saveNewsBody($new, $newsid);
	}
	
return $result?$newsid:false;
}

function saveNewsBody($new, $newsid=0){
	$db_fields = array(
			'newsid' =>		array('type'=>T_INT, 'value'=>$newsid),
			'title' =>		array('type'=>T_STR, 'value'=>''),
			'lang' =>		array('type'=>T_STR, 'value'=>null),
			'note' =>		array('type'=>T_STR, 'value'=>''),
			'body' =>		array('type'=>T_STR, 'value'=>' [empty] '),
			);

	
// INSERT
	$new['newsid'] = $newsid;
	$sql = DBprepare_insert('newsbody', $db_fields, $new);

	$result = DBexecute($sql);	
	
return $result?$newsid:false;
}

function deleteNews($newsids){
	cms_value2array($newsids);

	$result = deleteImagesByNewsIDs($newsids);

	deleteNewsBody($newsids);
	$sql= 'DELETE FROM news WHERE '.DBcondition('newsid',$newsids);
	$result = DBexecute($sql);
	
return $result;
}

function getAllNews($type=null){
global $ln;
	if ($type){
		$type = ' and news.type="'.$type.'" ';
	}
	$sql = 'select * from news, newsbody where news.newsid=newsbody.newsid and newsbody.lang="'.$ln.'" '.$type.' order by date desc';
	$res = DBselect($sql);
	$news = array();
	
	while ($row = DBfetch($res)){
		$row['date']=strftime('%d.%m.%Y',strtotime($row['date']));
		$news[] = $row;
		$news[sizeof($news)-1]['images']=array();
		$news[sizeof($news)-1]['mainimage']=false;
		$sql = 'select * from images where newsid="'.$row['newsid'].'"';
		$r = DBselect($sql);
		while ($row2 = DBfetch($r)){
			$news[sizeof($news)-1]['images'][]=$row2['file'];
			if ($row2['main']=='1'){
				$news[sizeof($news)-1]['mainimage'] = $row2['file'];
			}
		}
	}
	return $news;
}

function deleteNewsBody($newsids, $lang=null){
	cms_value2array($newsids);
	
	$sql_where = '';
	if(!is_null($lang))
		$sql_where = ' and lang='.db_str($lang);
		
	$sql= 'DELETE FROM newsbody WHERE '.DBcondition('newsid',$newsids).$sql_where;
	$result = DBexecute($sql);
	
return $result;
}
?>