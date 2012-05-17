<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
function getCommentByID($commentids){
	cms_value2array($commentids);
	
	$comments = array();
	$sql = ' SELECT c.* '.
			' FROM comments c '.
			' WHERE '.DBcondition('c.commentid', $commentids).
			' ORDER BY c.commentid';
	$res = DBselect($sql);
	while($comment = DBfetch($res)){
		$comments[$comment['commentid']] = $comment;
	}
	
return $comments;	
}
function getCommentsByPortfolioIDs($portfolioids){
	cms_value2array($portfolioids);	
	
	$comments = array();
	$sql = ' SELECT c.* '.
			' FROM comments c '.
			' WHERE '.DBcondition('c.portfolioid', $portfolioids).
			' ORDER BY c.commentid';

	$res = DBselect($sql);
	while($comment = DBfetch($res)){
		$comments[$comment['commentid']] = $comment;
	}
	
return $comments;
}

function saveComment($comment, $commentid=0){
	$db_fields = array(
			'commentid' =>		array('type'=>T_INT, 'value'=>$commentid),
			'lang' =>			array('type'=>T_STR, 'value'=>''),
			'portfolioid' =>	array('type'=>T_INT, 'value'=>0),
			'comment' =>		array('type'=>T_STR, 'value'=>'')
			);
			
// UPDATE
	if($commentid > 0){
		$sql = DBprepare_update('commentid', $commentid, 'comments', $db_fields, $comment);
	}
// INSERT
	else{
		$commentid = $comment['commentid'] = get_dbid('comments', 'commentid');
		$sql = DBprepare_insert('comments', $db_fields, $comment);
	}

	$result = DBexecute($sql);
	
return $result?$commentid:false;
}

function deleteCommentsByPortfolioIDs($portfolioids){
	cms_value2array($portfolioids);
	
	$sql = 'DELETE FROM comments WHERE '.DBcondition('portfolioid',$portfolioids);
	
	$result = DBexecute($sql);
return $result;
}
?>