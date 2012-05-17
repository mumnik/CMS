<?php

	class Image extends Model{
	
		protected $table = 'images';
		
		private $bindings = array(
			'description'	=> array(
				'table' 	=>	'description', 
				'update'	=> true,
				'key'		=> array(
					'id' 	=> 'imageid'
				),
				'data' 		=> array(
					'key' 	=> 'lang',
					'value' => 'string'
				)
			),
			'title' 		=> array(
				'table' 	=> 'street',
				'update' 	=> true,
				'key' 		=> array(
					'id'	=>'imageid'
				),
				'data' 		=> array(
					'key' 	=> 'lang',
					'value' => 'string'
				)
			)
		);
	
		private $folders = array(
			'original' 		=> array( 
				'method'	=>'copy' 
			),
			'thumbs' 		=> array( 
				'width' 	=> SITETHUMB_WIDTH, 
				'height' 	=> SITETHUMB_HEIGHT, 
				'method' 	=> 'cropresample'
			),
			'admin_thumbs' 	=> array( 
				'width' 	=> ADMINTHUMB_WIDTH, 
				'height' 	=> ADMINTHUMB_HEIGHT, 
				'method' 	=> 'cropresample' 
			),
			'largethumbs' 	=> array( 
				'width' 	=> 204, 
				'height' 	=> 140, 
				'method' 	=> 'cropresample' 
			),
			'small' 		=> array( 
				'width' 	=> 800, 
				'height' 	=> 600, 
				'method' 	=> 'resample' 
			),
			'smaller' 		=> array( 
				'width' 	=> 480, 
				'height' 	=> 338, 
				'method' 	=> 'resample' 
			)	
		);
	
		private function image_overlap($background, $foreground)
		{
			$insertWidth 	= imagesx($foreground);
			$insertHeight 	= imagesy($foreground);			
			$imageWidth 	= imagesx($background);
			$imageHeight 	= imagesy($background);			
			$overlapX 		= ($imageWidth - $insertWidth) / 2;
			$overlapY 		= ($imageHeight - $insertHeight) / 2;
			
			//imagecolortransparent($foreground, imagecolorat($foreground,0,0)); 
			imagesavealpha($foreground, true);
			imagecolortransparent($foreground, imagecolorallocatealpha($foreground, 0, 0, 0, 127)); 
			imagecopymerge($background, $foreground, $overlapX, $overlapY, 0, 0, $insertWidth, $insertHeight, 100);   
			
			return $background;
		}
		
		private function addWatermark($src, $dst, $watermark){ // hae ti add positioning here
			$watermark = imagecreatefrompng($watermark); 	
			imagealphablending($watermark, true);
			
			$watermark_width = imagesx($watermark);  
			$watermark_height = imagesy($watermark);  		
			
			$image = imagecreatefromjpeg($src);  
			$size = getimagesize($src);  	
			
			$dest_x = ($size[0] - $watermark_width) /2;  
			$dest_y = ($size[1] - $watermark_height) /2;  
			
			imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);  
			imagejpeg($image, $dst, 100);
			imagedestroy($image);  
			imagedestroy($watermark);  
			
			return true;
		}
		
		private function destinctImageTypeByExtention($image){
			$image = strtolower($image);
			
			if (strpos($image, '.jpg') || strpos($image, '.jpeg'))
				return 'jpg';
			
			if (strpos($image, '.png'))
				return 'png';
			
			if (strpos($image, '.gif'))
				return 'gif';
			
			return false;
		}
		
		/*private function resample($source, $dest, $stype, $params) 
		{
			
			$width 	= $params['width'];
			$height	= $params['height'];
			
			list($width_orig, $height_orig) = getimagesize($source);
			
			$nheight	= $height_orig;
			$nwidth		= $width_orig; 
			
			if ($nheight > $height)
			{				
				$nheight	= $nheight * ($height / $nheight);
				$nwidth 	= $nwidth * ($height / $nheight);
			} 
			
			if ($nwidth > $width) {				
				$nheight 	= $nheight * ($width / $nwidth);
				$nwidth 	= $nwidth * ($width / $nwidth);				
			}			
			
			
			// Resample
			$image_p = imagecreatetruecolor($nwidth, $nheight);
			switch($stype){
				case 'gif':
					$image = imagecreatefromgif($source);
				break;
				case 'jpg':
				case 'jpeg':
					$image = imagecreatefromjpeg($source);
				//	$black = imagecolorallocate($image, 0, 0, 0);
				//	imagefill($image, 0,0, $black);
				break;
				case 'png':
					imagealphablending($image_p, false);
					imagesavealpha($image_p, true); 
					
					$image = imagecreatefrompng($source);
					imagealphablending($image, true);
					
					//$background = imagecolorallocate($image_p, 0, 0, 0);
					//ImageColorTransparent($image_p, $background);
					//imagealphablending($image_p, false);
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
		}*/
		
		private function resample($source, $dest, $stype, $params) {		
			
			$width = $params['width'];
			$height = $params['height'];
			
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
				//	$black = imagecolorallocate($image, 0, 0, 0);
				//	imagefill($image, 0,0, $black);
				break;
				case 'png':
					imagealphablending($image_p, false);
					imagesavealpha($image_p, true); 
					
					$image = imagecreatefrompng($source);
					imagealphablending($image, true);
					
					//$background = imagecolorallocate($image_p, 0, 0, 0);
					//ImageColorTransparent($image_p, $background);
					//imagealphablending($image_p, false);
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
		
		private function crop($source, $dest, $stype, $params) 
		{
			$nw = $params['width'];
			$nh = $params['height'];

			$size = getimagesize($source);
			
			$w = $size[0];
			$h = $size[1];
		
			$proc_h = ($nh * 100) / $h;
			$proc_w = ($nw * 100) / $w;
			
			if($proc_h > $proc_w)
			{
				$nnh = $nh;
				$nnw = (int)(($proc_h * $w) / 100);
			}
			else {
				$nnh = (int)(($proc_w * $h) / 100);
				$nnw = $nw;
			}

			$dimg = imagecreatetruecolor($nw, $nh);
			$timg = imagecreatetruecolor($nnw, $nnh);
			
			switch ($stype)
			{
				case 'gif':
					$simg = imagecreatefromgif($source);
				break;
				case 'jpg':
				case 'jpeg':
					$simg = imagecreatefromjpeg($source);
				break;
				case 'png':
					/*
					imagealphablending($image_p, false);
					imagesavealpha($image_p, true); 
					
					$image = imagecreatefrompng($source);
					imagealphablending($image, true);
					*/
					imagealphablending($timg, false);
					imagesavealpha($timg, true);
					imagealphablending($dimg, false);
					imagesavealpha($dimg, true);
					
					$simg = imagecreatefrompng($source);
					imagealphablending($simg, true);
					
					/*$simg = imagecreatefrompng($source);
					$background = imagecolorallocate($simg, 0, 0, 0);
					ImageColorTransparent($dimg, $background);
					imagealphablending($dimg, false);
					ImageColorTransparent($timg, $background);
					imagealphablending($timg, false);*/
				break;	
				default:
					return false;
			}
		
			
			imagecopyresampled($timg,$simg,0,0,0,0,$nnw,$nnh,$w,$h);
			
			$shift_h = (int) (($nnh - $nh) / 2);
			$shift_w = (int) (($nnw - $nw) / 2);	

			imagecopy($dimg,$timg,0,0,$shift_w,0,$nnw,$nnh);
		
			switch ($stype)
			{
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
		
		private function cropresample($source, $dest, $stype, $params)
		{
			
			$nw = $params['width'];
			$nh = $params['height'];
			
			$size = getimagesize($source);
		
			$ratio=false;
			
			if ($nw > $nh)
				$ratio = number_format($size[0] / $nw, 0, '', '');
			else 
				$ratio = number_format($size[1] / $nh, 0, '', '');				
			
			if ($crop = $this->crop($source, $dest, $stype, array( 'width' => ($nw*$ratio), 'height' => ($nh*$ratio))))
				return $this->resample($dest, $dest, $stype, array('width' => $nw, 'height' => $nh));
			
			return false;			
		}

		/*	private function cropresample($source, $dest, $stype, $params){
			
			$nw = $params['width'];
			$nh = $params['height'];
			
			$size = getimagesize($source);
		
			$ratio=false;			
			if ($nw>$nh)
				$ratio=number_format($size[0]/$nw,0,'','');
			else 
				$ratio=number_format($size[1]/$nh,0,'','');
						

			if ($crop = $this->crop(
					$source, 
					$dest, 
					$stype, 
					array(
						'width'		=> ($nw*$ratio), 
						'height'	=> ($nh*$ratio) 
					)
				)
			){
				return $this->resample($dest, $dest, $stype, array('width'=>$nw, 'height'=>$nh));
			} 
			return false;			
		}	*/			
		
		private function copy($src, $dst, $ext, $params)
		{
			File::copyFile($src, $dst);
		}
	
		public function renameImage($id = false, $data)
		{			
			$arrays = false;
			
			foreach ($data as $key => $val)
				if (is_array($val))				
					$arrays[] = $key;					
			
			if (sizeof($arrays))			
				foreach ($arrays as $dependenttable)
				{
					$table2 = $this->table . $dependenttable;
					
					foreach($this->bindings[$dependenttable]['key'] as $lk => $rk)
					{
						$localkey 	= $lk;
						$remotekey 	= $rk;
					}					
					
					foreach ($data[$dependenttable] as $key=>$val)
					{
						$sql = 'REPLACE INTO ' . $table2 . ' SET '.
							$this->bindings[$dependenttable]['data']['key'] . ' = "' . mysql_escape_string($key) . '",' . 
							$this->bindings[$dependenttable]['data']['value'] . ' = "' . $val . '", ' .	$remotekey . ' = "' . $id . '"';

						DBexecute($sql);
					}
				}

			return true;
		}

		private function getImageParent($imageid)
		{
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE id = "' . $imageid . '"';
			$res = mysql_query($sql);			
			if ($res)
			{
				$row = mysql_fetch_assoc($res);
				return $row['parentid'];				
			} 
			
			return false;
		}
		
		public function setImageMain($imageid, $parentid = false)
		{
			if (!$parentid)			
				$parentid = $this->getImageParent($imageid);
			
			if (!$parentid)
				return false;
			
			$result = true;
			
			$sql = 'UPDATE ' . $this->table . ' SET main="0" WHERE parentid = "' . $parentid . '"';
			$result &= DBexecute($sql);
	
			$sql = 'UPDATE ' . $this->table . ' SET main="1" WHERE id="' . $imageid . '"';
			$result &= DBexecute($sql);

			return $result;
		}
		 
	/*	public function changeImageSortIndex($imageid, $direction) //depricated
		{
			$current = $this->getImage($imageid);
			
			if (($direction == 'down') && ($current['sortindex']<=1))
				return;
			
			$parentid = $current['parentid'];			
			
			$list = $this->getImagesByParentId($parentid);			
			
			if (($direction == 'up') && ($current['sortindex']>=sizeof($list)))
				return;				
				
			$next = false;
			// we presume that items are sorted			
			if ($direction=='down')
			{				
				$i = sizeof($list);
				$modcurrent = '-';
				$modnext = '+';
				while ($i >= 0)
				{
					if ($list[$i]['id'] == $current['id'])
					{
						$next = $list[$i-1];
						break;
					}
					$i--;
				}				
			}
			else {			
				$i = 0;
				$modcurrent = '+';
				$modnext = '-';
				while ($i<=sizeof($list))
				{					
					if ($list[$i]['id']==$current['id'])
					{						
						$next = $list[$i+1];
						break;
					}
					$i++;
				}
			}
			
			// if they are next to each other, we have to change both indexes. 
			// may be there are some cases when no next value avalible, so i added a check			
			if ((abs($current['sortindex']-$next['sortindex'])==1)&&($next)) 
			{				
				$sql = 'update '.$this->table.' set sortindex=sortindex'.$modnext.'1 where id = "'.$next['id'].'"';
				mysql_query($sql);
				
			}		
			$sql = 'update '.$this->table.' set sortindex=sortindex'.$modcurrent.'1 where id = "'.$current['id'].'"';
			mysql_query($sql);
			
		}*/  
		
		public function uploadImage($filename = false, $folders = false, $parentid = false, $data = false)
		{
			global $CONF;	
			
			$ext = File::getExtension($_FILES[$filename]['name']);
			$newname = time() . '.' . $ext;		
			
			if (file_exists(TMP . '/' . $newname))
				File::deleteFile(TMP . '/' . $newname);
			
			if (!isset($data['main']))
				$data['main'] = 0;
			
			$result = File::uploadFile($filename, $newname, TMP);
			
			if ($result)
			{
				
				$sql = ''.
					' insert into '. 
						$this->table. 
					' set'.
					'	file = "' . $newname . '", '.
					' 	uploaddate = Now(), '.
					' 	link = "' . $data['link'] . '", '.
					' 	sortindex = "' . $data['sortindex'] . '", '. // possibly improve this
					'	parentid = "' . $parentid . '", '.
					'	main = "' . $data['main'] . '" '. // possibly improve this
					'';
				mysql_query($sql);					
				$id = mysql_insert_id();
								
				foreach ($this->folders as $folder => $params)								
					$this->$params['method'](TMP . '/' . $newname, GALLERY . '/' . $folder . '/' . $newname, $ext, $params);				
				
				$data['file'] 		= $newname;
				$data['parentid'] 	= $parentid;				
				
				$this->renameImage($id, $data);				
					
				$result = $id;
			}

			return $result;
		}
		
		public function overrideImageIndex($imageid, $index){
			$sql = 'update images set sortindex = ' . $index . ' where id = ' . $imageid;
			
			return DBexecute($sql);
		}
		
		public function getMaxSortIndexByParentId($parentid)
		{
			$sql = 'select MAX(sortindex) as sortindex from ' . $this->table	.' where parentid = "' . $parentid . '"';			
			$res = mysql_query($sql);
			$row = mysql_fetch_array($res);
			
			return $row['sortindex'];
		}
		
		public function getNextSortIndexByParentId($parentid)		
		{			
			return $this->getMaxSortIndexByParentId($parentid)+1;
		}
		
		public function eraseImage($id)
		{			
			global $CONF;
			
			$result = true;
			
			$image = $this->getImage($id);			
			
			$sql = 'delete from '.$this->table.' where id="'.$id.'"';
			$result &= DBexecute($sql);
			
			if (sizeof($this->bindings))
				foreach ($this->bindings as $dependenttable=>$data)
				{
					foreach($this->bindings[$dependenttable]['key'] as $lk=>$rk)
					{
						$localkey = $lk;
						$remotekey = $rk;
					}	
					$sql = 'delete from ' . $this->table . $dependenttable . ' where ' . $remotekey . '="' . $id . '"';
					$result &= DBexecute($sql);			
				}
				
			foreach ($this->folders as $folder => $params)
				if (file_exists(GALLERY . '/' . $folder . '/' . $image['file']))
					$result &= File::deleteFile(GALLERY . '/' . $folder . '/' . $image['file']);
			
			return $result;
		}
	
		public function getImagesByParentId($parentid){		
			
			$sql = 'select ' . $this->table . '.* from ' . $this->table	. ' ';
			$sql .= ' where ' . $this->table . '.parentid = "' . $parentid . '"';
			$sql.= ' order by sortindex';			
			
			$res = mysql_query($sql);
			$result = array();
			
			while ($row = mysql_fetch_assoc($res)){			
				
				foreach ($this->bindings as $table=>$data){
					$sql2 = 'select * from ' . $this->table.$table . ' where ';
					foreach ($data ['key'] as $lk => $rk){
						$sql2 .= $this->table.$table . '.' . $rk . ' = "' . $row[$lk] . '"';
					}
					
					$res2 = mysql_query($sql2);										
					if ($res2)
					{
						while ($row2 = mysql_fetch_assoc($res2)){														
							$row[$table][$row2[$data['data']['key']]] = $row2[$data['data']['value']];							
						}						
					} 
					else {
						$row[$table] = array();
					}
				}
				$result[] = $row;
			}					
			return $result;
		}
	
		public function getImage($id){
		
			$sql = 'select ' . $this->table . '.* ';
			
			if (sizeof($this->bindings)){				
				foreach ($this->bindings as $table=>$data){					
					$sql .= ', ' . $table . '.' . $data['data']['key'] . ' as ' 
						. $table.'key, ' . $table . '.' . $data['data']['value'] . ' as '.$table.'string ';
				}
			}			
			$sql .= 'from ' . $this->table . ' ';
			if (sizeof($this->bindings)){
				foreach ($this->bindings as $table=>$data){
					$combinedtable = $this->table.$table;
					$sql .= ' left join ' . $combinedtable . ' as ' . $table . ' on ';
					foreach ($data ['key'] as $lk => $rk){
						$sql .= $this->table . '.' . $lk . '=' . $table . '.' . $rk;
					}
				}
			}
			$sql .= ' where ' . $this->table . '.id ="' . $id . '"';
			
			$res = mysql_query($sql);
			$row = mysql_fetch_assoc($res);
			
			return $row;
		}
		
		function __construct($data){
			parent::__construct();
		}
		
	}