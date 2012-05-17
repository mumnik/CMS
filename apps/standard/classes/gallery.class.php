<?php

	class Gallery extends Model
	{
		
		private $id = false;
		
		protected $table = 'galleries';				
		
		private $bindings = array(
			'description' 	=> array(
				'table' 	=> 'description', 
				'update' 	=> true,
				'key' 		=> array(
					'id' 	=> 'galleryid'
				),
				'data' 		=> array(
					'key' 	=> 'lang',
					'value' => 'string'
				)
			),
			'title' 		=> array(
				'table' 	=> 'title',
				'update' 	=> true,
				'key' 		=> array(
					'id'	=>'galleryid'
				),
				'data' 		=> array(
					'key' 	=> 'lang',
					'value' => 'string'
				)
			)
		);
		
		public $galleries = false;
		
		public function setId($id){
			if (!$this->id)
				$this->id = $id;
		}	
		
		public $uses = array('Image'=>array());
		
		public function __construct(){
			parent::__construct();
		}
		
		public function getImages($parentid = false)
		{
			if (!$parentid)
				$parentid = $this->id;					
			
			if (!isset($this->galleries[$parentid]))						
				$this->galleries[$parentid] =  $this->Image->getImagesByParentId($parentid);
			
			return $this->galleries[$parentid];
		}
		
		public function removeImage($id)
		{
			$this->Image->eraseImage($id);
		}
		
		public function changeImageSortIndex($imageid, $direction){
			$this->Image->changeImageSortIndex($imageid, $direction);
		}
		
		public function updateImageIndex($image, $index)
		{
			return $this->Image->overrideImageIndex($image, $index);
		}
		
		public function addImage($filename, $folders=false, $parentid = false, $data)
		{
			if (!$parentid)
				$parentid = $this->id;
				
			if (!$parentid)
				die('Error: parent id not set');
			
			$data['sortindex'] = $this->Image->getNextSortIndexByParentId($parentid);			
			$imageid = $this->Image->uploadImage($filename, $folders, $parentid, $data);
			
			if (isset($data['main']) && $data['main'])
				$this->setImageMain($imageid, $parentid);		
			
			if (sizeof($this->getImages($parentid)) == 1)
				$this->setImageMain($imageid, $parentid);
						
			return true;
			
		}
		
		public function renameImage($imageid, $data){		
			return $this->Image->renameImage($imageid, $data);
		}
		
		public function setImageMain($imageid, $galleryid = false){
			return $this->Image->setImageMain($imageid, $galleryid);
		}
		
		public function getNextSortIndex($parentid = false)
		{
			if (!$parentid)
				$parentid = $this->id;		
			
			if (!$parentid)
				die('Error: parent id not set');
				
			return $this->Image->getNextSortIndexByParentId($parentid);
		}
		
		public function getGalleryById($galleryid)
		{
			$result = false;
			
			$sql = ''.
				'SELECT '.
					$this->table.'.*';
				
			foreach ($this->bindings as $binding => $data)				
				$sql .= ', ' . $this->table . $binding . '.'. 
					$data['data']['value'] . ' as ' . $binding . ', ' . 
					$this->table . $binding . '.' .	$data['data']['key'];
				
			$sql .= ' FROM '.
				$this->table;				
				
			foreach ($this->bindings as $binding => $data)
				$sql .= ' LEFT JOIN '.
					$this->table . $binding.
					' ON '.
						$this->table .'.id = ' . $this->table . $binding . '.' . $data['key']['id'];
			
			$sql .= ' WHERE '.
				'galleriestitle.lang = galleriesdescription.lang'; // fuck this shit...
				
			$sql .= ' AND '.
				$this->table . '.id = "' . $galleryid . '"'; 
			
			$res = DBselect($sql);
			
			if ($res)
			{
				while ($row = DBfetch($res))
				{
					$result[$row['id']]['title'][$row['lang']] 			= $row['title'];
					$result[$row['id']]['description'][$row['lang']] 	= $row['description'];
					$result[$row['id']]['type'] 						= $row['type'];
					$result[$row['id']]['moduleid'] 					= $row['moduleid'];
					$result[$row['id']]['galleryid'] 					= $row['id'];
				}
				$result = array_shift(array_values($result));
			}		
			
			return $result;
		}
		
		public function renameGallery($id = false, $data)
		{			
			if (!$id)
				die('Error: id not set');
				
			$arrays = false;				
			
			$sql = 'UPDATE ' . $this->table . ' SET ';
			$f = '';						
			foreach ($data as $key => $val)				
				if (is_array($val))				
					$arrays[] = $key;	
				else {
					$sql .= $f . $key . ' = "' . mysql_escape_string($val) . '"';
					$f = ',';
				}
			
			$sql .= ' WHERE id = "' . $id . '"';			
			DBexecute($sql);

			if (sizeof($arrays))
				foreach ($arrays as $dependenttable)
				{
					$table2 = $this->table . $dependenttable;					
					$f = '';
					
					foreach($this->bindings[$dependenttable]['key'] as $lk=>$rk)
					{
						$localkey = $lk;
						$remotekey = $rk;
					}					
					
					foreach ($data[$dependenttable] as $key=>$val)
					{
						$sql = 'REPLACE INTO ' . $table2 . ' SET '.
							$this->bindings[$dependenttable]['data']['key'] . ' = "'. 
							mysql_escape_string(htmlspecialchars($key)) . '",' . 
							$this->bindings[$dependenttable]['data']['value'] . ' = "' . mysql_escape_string(htmlspecialchars($val)) . '", '.
							$remotekey . ' = "' . $id . '"';										
						DBexecute($sql);									
					}
				}			
			
			return true;
		}
		
		public function getGalleries()		
		{
			$result = array();
			
			if (!$this->galleries)
			{
				$sql = ''.
					'SELECT '.
						$this->table.'.*';
					
				foreach ($this->bindings as $binding => $data)				
					$sql .= ', ' . $this->table . $binding . '.'. 
						$data['data']['value'] . ' as ' . $binding . ', ' . 
						$this->table . $binding . '.' .	$data['data']['key'];
				
				$sql .= ' FROM '.
					$this->table;				
					
				foreach ($this->bindings as $binding => $data)
					$sql .= ' LEFT JOIN '.
						$this->table . $binding.
						' ON '.
							$this->table .'.id = ' . $this->table . $binding . '.' . $data['key']['id'];
				
				$sql .= ' WHERE '.
					'galleriestitle.lang = galleriesdescription.lang'; // fuck this shit...
				
				$res = DBselect($sql);
				
				if ($res)			
					while ($row = DBfetch($res))
					{
						$result[$row['id']]['title'][$row['lang']] 			= $row['title'];
						$result[$row['id']]['description'][$row['lang']] 	= $row['title'];
						$result[$row['id']]['type'] 						= $row['type'];
						$result[$row['id']]['moduleid'] 					= $row['moduleid'];
						$result[$row['id']]['galleryid'] 					= $row['id'];
					}				
					$this->galleries = $result;
					
					$result = array();
			}
			
			if ($this->galleries)
				foreach ($this->galleries as $gallery)
					$result[] = $gallery;			
			
			return $result;
		}
		
		public function createGallery($data)
		{			
			$sql = 'insert into ' . $this->table . ' values ()';
			if (!DBexecute($sql))
				die('Error: error creating gallery');
			
			$id = mysql_insert_id();

			$this->renameGallery($id, $data);
			
			return $id;
		}
		
		public function deleteImage($id = false)
		{
			if (!$id)
				$id = $this->$id;
			
			if (!$id)
				die('Error: id not set');
				
			return $this->Image->eraseImage($id);
		}
		
		public function getGalleriesByModuleId($moduleid)
		{
			
			$result = array();
			
			$sql = ''.
				' SELECT '.
					$this->table . '.*'.
				'';
				
			foreach ($this->bindings as $binding => $data)				
				$sql .= ', ' . $this->table . $binding . '.'. 
					$data['data']['value'] . ' as ' . $binding . ', ' . 
					$this->table . $binding . '.' .	$data['data']['key'];	
					
			$sql .= ''.
				' FROM '.
					$this->table.
				'';
			
			foreach ($this->bindings as $binding => $data)
				$sql .= ' LEFT JOIN '.
					$this->table . $binding.
					' ON '.
						$this->table .'.id = ' . $this->table . $binding . '.' . $data['key']['id'];				
						
			$sql .= ' WHERE '.
				$this->table.'.moduleid = "' . $moduleid . '"'.				
			' AND '.
			' 	galleriestitle.lang = galleriesdescription.lang'; // fuck this shit...
			'';
			
			$res = DBselect($sql);
			
			if ($res)
				while ($row = DBfetch($res))
				{				
					$result[$row['id']]['title'][$row['lang']] 			= $row['title'];
					$result[$row['id']]['description'][$row['lang']] 	= $row['description'];
					$result[$row['id']]['galleryid'] 					= $row['id'];
				}
				
			foreach ($result as $galleryid => $data)
				$result[$galleryid]['images'] = $this->getImages($galleryid);
				
			return array_values($result);
		}
		
		public function eraseGallery($galleryid = false)
		{
			
			if (!$galleryid)
				$galleryid = $this->$id;
			
			if (!$galleryid)
				die('Error: id not set');
			
			$list = $this->getImages($galleryid);
			
			if (count($list))
				foreach ($list as $id => $data)
					$this->Image->eraseImage($id);
			
			$sql = 'DELETE FROM ' . $this->table . ' WHERE id = "' . $galleryid . '"';
			
			return DBexecute($sql);
		}
		
	}