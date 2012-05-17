<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php
function getImagesByID($imageids, $showall=false){
	cms_value2array($imageids);

	$sql_where = '';
	if(!$showall){
		$sql_where.= ' AND i.index>0 ';
	}
	$images = array();
	$sql = ' SELECT i.* '.
			' FROM images i '.
			' WHERE '.DBcondition('i.imageid',$imageids).
				$sql_where.
			' ORDER BY i.index';
	$res = DBselect($sql);
	while($image = DBfetch($res)){
		$images[$image['imageid']] = $image;
	}
	
return $images;
}

function getImagesByPortfolioId($portfolioids, $showall=false){
	cms_value2array($portfolioids);

	$sql_where = '';
	if(!$showall){
		$sql_where.= ' AND i.index>0 ';
	}
	$images = array();
	$sql = ' SELECT i.* '.
			' FROM images i '.
			' WHERE '.DBcondition('i.portfolioid',$portfolioids).
				' AND i.newsid=0 '.
				$sql_where.
			' ORDER BY i.index';
	$res = DBselect($sql);
	while($image = DBfetch($res)){
		$images[$image['imageid']] = $image;
	}
	
return $images;
}

function getImagesByNewsId($newsid, $showall=false){
	cms_value2array($newsid);
	
	$sql_where = '';
	if(!$showall){
		$sql_where.= ' AND i.index>0 ';
	}
	$images = array();
	$sql = ' SELECT i.* '.
			' FROM images i '.
			' WHERE '.DBcondition('i.newsid',$newsid).
				' AND i.portfolioid=0 '.
				$sql_where.
			' ORDER BY i.index';
	$res = DBselect($sql);
//	echo $sql;
	while($image = DBfetch($res)){
		$images[$image['imageid']] = $image;
	}

return $images;
}


function saveVideo($video, $videoid=0){

	$db_fields = array(
			'videoid' =>	array('type'=>T_INT, 'value'=>$videoid),
			'url' =>		array('type'=>T_STR, 'value'=>null),
			'portfolioid' =>array('type'=>T_INT, 'value'=>0),
			'newsid'=>		array('type'=>T_INT, 'value'=>0),
			'productid'=>		array('type'=>T_INT, 'value'=>0),
			'galleryid' =>	array('type'=>T_INT, 'value'=>0),
	
			'index' =>		array('type'=>T_INT, 'value'=>1),
			'text'=>		array('type'=>T_STR, 'value'=>null)
			);
			
// UPDATE
	if($videoid > 0){
		$sql = DBprepare_update('videoid', $videoid, 'videos', $db_fields, $video);
	}
// INSERT
	else{
		$videoid = $video['videoid'] = get_dbid('videos', 'videoid');
		$sql = DBprepare_insert('videos', $db_fields, $video);
	}
	
	$result = DBexecute($sql);	
	
return $result?$videoid:false;
}

function deleteVideo($videoid){
		$sql = 'delete from videos where videoid="'.$videoid.'"';
	//debug($sql);

	return DBexecute($sql);
}

function saveImage($image, $imageid=0){
//debug($image);
	$db_fields = array(
			'imageid' =>	array('type'=>T_INT, 'value'=>$imageid),
			'file' =>		array('type'=>T_STR, 'value'=>null),
			'url' =>		array('type'=>T_STR, 'value'=>null),
			'portfolioid' =>array('type'=>T_INT, 'value'=>0),
			'newsid'=>		array('type'=>T_INT, 'value'=>0),
			'productid'=>		array('type'=>T_INT, 'value'=>0),
			'galleryid' =>	array('type'=>T_INT, 'value'=>0),
			'main' =>		array('type'=>T_INT, 'value'=>0),
			'index' =>		array('type'=>T_INT, 'value'=>1),
			'text'=>		array('type'=>T_STR, 'value'=>null)
			);
			
// UPDATE
	if($imageid > 0){
		$sql = DBprepare_update('imageid', $imageid, 'images', $db_fields, $image);
	}
// INSERT
	else{
		$imageid = $image['imageid'] = get_dbid('images', 'imageid');
		$sql = DBprepare_insert('images', $db_fields, $image);
	}
	
	$result = DBexecute($sql);	
	
return $result?$imageid:false;
}

function image_overlap($background, $foreground){
	$insertWidth = imagesx($foreground);
	$insertHeight = imagesy($foreground);
	
	$imageWidth = imagesx($background);
	$imageHeight = imagesy($background);
	
	$overlapX = ($imageWidth-$insertWidth)/2;
	$overlapY = ($imageHeight-$insertHeight)/2;
	
	//imagecolortransparent($foreground, imagecolorat($foreground,0,0)); 
	imagesavealpha($foreground, true);
	imagecolortransparent($foreground, imagecolorallocatealpha($foreground, 0,0,0,127)); 
	imagecopymerge($background,$foreground,$overlapX,$overlapY,0,0,$insertWidth,$insertHeight,100);   
	
	return $background;
}


function addWatermark($src, $dst, $watermark){
	$watermark = imagecreatefrompng($watermark); 	
	imagealphablending($watermark, true);
	
	$watermark_width = imagesx($watermark);  
	$watermark_height = imagesy($watermark);  		
	
	$image = imagecreatefromjpeg($src);  
	//imagealphablending($image,true);
	$size = getimagesize($src);  	
	
	$dest_x = ($size[0] - $watermark_width) /2;  
	$dest_y = ($size[1] - $watermark_height) /2;  
	//$image = image_overlap($image, $watermark);	
	   
	imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);  
	imagejpeg($image, $dst, 100);
	imagedestroy($image);  
	imagedestroy($watermark);  
	return true;
}

function deleteImagesByPortfolioIDs($portfolioids){
	cms_value2array($portfolioids);
	
	$images = getImagesByPortfolioId($portfolioids, true);
	$imageids = array_keys($images);
	
	$result = deleteImages($imageids);
return $result;
}

function deleteImagesByNewsIDs($newsids){
	cms_value2array($newsids);

	$images = getImagesByNewsId($newsids, true);
	$imageids = array_keys($images);

	$result = deleteImages($imageids);
return $result;
}

function deleteImages($imageids){
	global $CONF;
	
	cms_value2array($imageids);
	$images = getImagesByID($imageids);

	foreach($images as $imageid => $image){
		@unlink($CONF['location'].'gallery/original/'.$image['file']);
		@unlink($CONF['location'].'gallery/portfolio/'.$image['file']);
		@unlink($CONF['location'].'gallery/thumbs/'.$image['file']);
		@unlink($CONF['location'].'gallery/small/'.$image['file']);
		@unlink($CONF['location'].'gallery/icons_72/'.$image['file']);
		@unlink($CONF['location'].'gallery/randimages/'.$image['file']);
		@unlink($CONF['location'].'gallery/videothumbs/'.$image['file']);
	}
	
	$sql= 'DELETE FROM images WHERE '.DBcondition('imageid',$imageids);
	$result = DBexecute($sql);
	
	$sql = 'DELETE FROM image_titles WHERE '.DBcondition('imageid',$imageids);
	$result = DBexecute($sql);
return $result;
}

function destinctImageTypeByExtention($image){
	$image=strtolower($image);
	if ((strpos($image, '.jpg'))||(strpos($image, '.jpeg'))){
		return 'jpg';
	}
	if (strpos($image, '.png')){
		return 'png';
	}
	if (strpos($image, '.gif')){
		return 'gif';
	}
	return false;
}

function resampleImage($source, $dest, $stype, $width, $height) {
	// Get new dimensions

	list($width_orig, $height_orig) = getimagesize($source);
	
	$nheight=$height_orig;
	$nwidth=$width_orig; 
	
	if ($nheight>$height){
		$c = $height/$nheight;
		$nheight = $nheight*$c;
		$nwidth = $nwidth * $c;
	}

	if ($nwidth>$width){
		$c = $width/$nwidth;
		$nwidth = $nwidth*$c;
		$nheight = $nheight*$c;
	}
	//echo 'h:'.$nheight.'<br>';
	//echo 'w:'.$nwidth.'<br>';
	//exit;
	unset($c);
	
	// Resample
	$image_p = imagecreatetruecolor($nwidth, $nheight);
	switch($stype){
		case 'gif':
			$image = imagecreatefromgif($source);
		break;
		case 'jpg':
		case 'jpeg':
			$image = imagecreatefromjpeg($source);
		break;
		case 'png':
			$image = imagecreatefrompng($source);
			$background = imagecolorallocate($image_p, 0, 0, 0);
			ImageColorTransparent($image_p, $background);
			imagealphablending($image_p, false);
		break;
		default:
			return false;
	}
	
	//imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $nwidth, $nheight, $width_orig, $height_orig);
	
	//imagejpeg($image_p, $dest, 100);
	
	switch($stype){
		case 'gif':
			 imagegif($image_p,$dest);
		break;
		case 'jpg':
		case 'jpeg':
			 imagejpeg($image_p,$dest,100);
		break;
		case 'png':
			 imagepng($image_p,$dest);
		break;
		default: 
			return false;
	}
	

	return true; 
}

function cropImage($source, $dest, $stype, $nw, $nh) {
	$size = getimagesize($source);
	$w = $size[0];
	$h = $size[1];

	$proc_h = ($nh * 100)/$h;
	$proc_w = ($nw * 100)/$w;
	if($proc_h > $proc_w){
		$nnh = $nh;
		$nnw = (int)($proc_h * $w) / 100;
	}
	else{
		$nnh = (int)($proc_w * $h) / 100;
		$nnw = $nw;
	}
	
	
	$dimg = imagecreatetruecolor($nw, $nh);
	$timg = imagecreatetruecolor($nnw, $nnh);
	
	switch($stype){
		case 'gif':
			$simg = imagecreatefromgif($source);
		break;
		case 'jpg':
		case 'jpeg':
			$simg = imagecreatefromjpeg($source);
		break;
		case 'png':
			$simg = imagecreatefrompng($source);
			$background = imagecolorallocate($simg, 0, 0, 0);
			ImageColorTransparent($dimg, $background);
			imagealphablending($dimg, false);
			ImageColorTransparent($timg, $background);
			imagealphablending($timg, false);
		break;	
		default:
			return false;
	}

	
	imagecopyresampled($timg,$simg,0,0,0,0,$nnw,$nnh,$w,$h);
	
	$shift_h = (int) (($nnh - $nh) / 2);
	$shift_w = (int) (($nnw - $nw) / 2);

//	imagecopy($dimg,$timg,0,0,$shift_w,$shift_h,$nnw,$nnh);
	imagecopy($dimg,$timg,0,0,$shift_w,0,$nnw,$nnh);

	switch($stype){
		case 'gif':
			return imagegif($dimg,$dest);
		break;
		case 'jpg':
		case 'jpeg':
			return imagejpeg($dimg,$dest,100);
		break;
		case 'png':
			return imagepng($dimg,$dest);
		break;
		default: 
			return false;
	}
}


function makeThumb($file){
	global $CONF;
	
	list($width_orig, $height_orig) = getImageSize($CONF['location'].'gallery/original/'.$file);		 
	$new_width = 251;
	$new_height = 288;
	
	if($new_width && ($width_orig < $height_orig)) {
		$new_width = ($new_height / $height_orig) * $width_orig;
	} 
	else {
		$new_height = ($new_width / $width_orig) * $height_orig;
	}		 
	
	$thumb = @imagecreatetruecolor($new_width,$new_height);
	$tmp_image = @imagecreatefromjpeg($CONF['location'].'gallery/original/'.$file);
	if(!$tmp_image) return false;
	
	imagecopyresampled($thumb, $tmp_image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
	//header('Content-Type: image/jpeg');
	//header("Content-Disposition: attachment; filename=$file");
	imagejpeg($thumb, $CONF['location'].'gallery/thumbs/'.$file,100);
	imagedestroy($thumb);
	
	if(file_exists($CONF['location'].'gallery/thumbs/'.$file)){
		return true;
	} 
	else {
		return false;
	}
}
?>