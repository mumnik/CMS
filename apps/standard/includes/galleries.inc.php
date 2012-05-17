<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
function getGelleriesByID($galleryids, $showall=false){
	cms_value2array($galleryids);

	$sql_where = '';
	if(!$showall){
//		$sql_where.= ' AND i.index>0 ';
	}
	$galleries = array();
	$sql = ' SELECT g.* '.
			' FROM galleries g '.
			' WHERE '.DBcondition('g.galleryid',$galleryids).
				$sql_where.
			' ORDER BY g.title';
	$res = DBselect($sql);
	while($gallery = DBfetch($res)){
		$galleries[$gallery['galleryid']] = $gallery;
	}
	
return $galleries;
}

function saveGallery($gallery, $galleryid=0){
	$db_fields = array(
			'galleryid' =>		array('type'=>T_INT, 'value'=>$galleryid),
			'module' =>			array('type'=>T_STR, 'value'=>''),
			'title' =>			array('type'=>T_STR, 'value'=>'')
			);
			
// UPDATE
	if($galleryid > 0){
		$sql = DBprepare_update('galleryid', $galleryid, 'galleries', $db_fields, $gallery);
	}
// INSERT
	else{
		$galleryid = $gallery['galleryid'] = get_dbid('galleries', 'galleryid');
		$sql = DBprepare_insert('galleries', $db_fields, $gallery);
	}

	$result = DBexecute($sql);	
	
return $result?$galleryid:false;
}

function saveVideoGallery($gallery, $galleryid=0){
	$db_fields = array(
			'galleryid' =>		array('type'=>T_INT, 'value'=>$galleryid),
			'module' =>			array('type'=>T_STR, 'value'=>''),
			'title' =>			array('type'=>T_STR, 'value'=>'')
			);
			
// UPDATE
	if($galleryid > 0){
		$sql = DBprepare_update('galleryid', $galleryid, 'videogalleries', $db_fields, $gallery);
	}
// INSERT
	else{
		$galleryid = $gallery['galleryid'] = get_dbid('videogalleries', 'galleryid');
		$sql = DBprepare_insert('videogalleries', $db_fields, $gallery);
	}

	$result = DBexecute($sql);	
	
return $result?$galleryid:false;
}

function deleteGalleries($galleryids){
	cms_value2array($galleryids);
	
	$sql= 'DELETE FROM galleries WHERE '.DBcondition('galleryid',$galleryids);
	$result = DBexecute($sql);
	
return $result;
}
?>