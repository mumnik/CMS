<?php

	class File
	{
	
		public static function getExtension($filename){			
			$ext = strtolower(substr(strrchr($filename,'.'), 1));			
			if ($ext=='jpeg'){
				$ext='jpg';
			}			
			return $ext;
		}
		
		public static function deleteFile($filename){
			$result = false;
			try {
				$result = unlink($filename);
			} 
			catch (Exception $e){
				debug($e);
			}
			
			return $result;
		}
		
		public static function copyFile($src, $dst){
			try{
				copy ( $src , $dst);
			} 
			catch (Exception $e){
				debug($e);
			}	
		}
		
		public static function moveFile($src, $dst){
			try{
				rename ( $src , $dst);
			} 
			catch (Exception $e){
				debug($e);
			}			
		}
		
		public static function uploadFile($filename, $newname=false, $dst){
			if (!$newname){
				$newname = $_FILES[$filename]['name'];
			}
			$target = $dst . '/' . $newname;
			if (move_uploaded_file($_FILES[$filename]['tmp_name'], $target)){
				return array(
					'result' => 'ok', 
					'target' => $target,
					'file' => $newname, 
					'type' => $_FILES[$filename]['type'], 
					'size' => $_FILES[$filename]['size']
				);
			}
			return false;
		}
	
	}