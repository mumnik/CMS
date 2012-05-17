<?php

	
	require_once('conf/config.php');
	
	$nookid = get_request('nookid', 0);
	
	if ($nookid>0){
		$imageObj = new image(); 
		$video = $imageObj->getNookById($nookid);
		if ($video){
			//debug($video);//['videourl'];
			
			echo '
				<div style="width:500px; height: 370px;">
			<br><center>
				<object width="425" height="344">
					<param name="movie" value="http://www.youtube.com/v/'.$video['videourl'].'&amp;hl=en_US&amp;fs=1&amp;">
					<param name="allowFullScreen" value="true">
					<param name="allowscriptaccess" value="always">
					<embed src="http://www.youtube.com/v/'.$video['videourl'].'&amp;hl=en_US&amp;fs=1&amp;" 
						type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" 
						width="425" height="344">
				</object>
				</center>
				</div>
				
			';
		} else {
			echo 'error in DB';
		}
	} else {
		echo 'error in ID';
	}

?>