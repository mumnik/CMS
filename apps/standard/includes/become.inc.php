<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

function saveBecomeImages($portfolioid){
	global $CONF;
	
	$result = false;
	
	if(isset($_FILES['images'])){

		foreach($_FILES['images'] as $name => $file){
			$result = false;
			if(isset($file['tmp_name']) && !empty($file['tmp_name']) && ($file['size'] < 2000000)){

				$image = array();
				$image['file'] = time().'.jpg';
				$image['portfolioid'] = $portfolioid;
				$image['index'] = 1;

				$target_path = $CONF['location'].'gallery/original/';
				$target_path = $target_path.$image['file'];

				try{
					$result = move_uploaded_file($file['tmp_name'], $target_path);
					$result &= resampleImage($target_path, $CONF['location'].'/gallery/thumbs/'.$image['file'], 'jpg', 251, 288);
					$result &= resampleImage($target_path, $CONF['location'].'/gallery/portfolio/'.$image['file'], 'jpg', 322, 429);
					$result &= resampleImage($target_path, $CONF['location'].'/gallery/small/'.$image['file'], 'jpg', 121, 155);
					$result &= resampleImage($target_path, $CONF['location'].'/gallery/icons_72/'.$image['file'], 'jpg', 72, 72);
				}
				catch(Exception $e){
					print('There was an error uploading the file, please try again! ['.$e->getMessage().']');
				}

				if($result) saveImage($image);
			}
		}
	}
return $result;
}
?>