<?php
	
	$galleryObj = new gallery();
	
	$action = get_request('action', false);

	switch ($action)
	{
		case 'setImageMain':
			$imageid = get_request('imageid', 0);			
			$galleryid = get_request('galleryid', 0);
			
			$result = $galleryObj->setImageMain($imageid, $galleryid);			
			
			json_headers(
				array(
					'status' => $result ? 'OK' : 'FAILURE',
					'id' => $imageid
				)
			);
			exit;
		break;
		
		case 'changeImageOrd':
			$data = $_POST['ids'];
			$result = true;
			foreach ($data as $i => $id)
				$result &= $galleryObj->updateImageIndex($id, $i);
			
			json_headers(
				array(
					'status' => $result ? 'OK' : 'FAILURE'
				)
			);			
			exit;
		break;
		
		case 'images':
			$content_tpl = new xTemplate($CONF['location'].'apps/standard/tpl/adm/gallery_images.html');
			$galleryid = get_request('galleryid', 0);			
			
			$info = $galleryObj->getGalleryById($galleryid);
			$content_tpl->assign('gallerytitle', $info['title'][$CONF['languages'][0]]);
			for ($i=0, $ic = sizeof($CONF['languages']); $i < $ic; $i++)
			{
				$content_tpl->assign('tlang', $CONF['languages'][$i]);
				$content_tpl->parse('main.titlelangs.titlelang');
			}
			$content_tpl->parse('main.titlelangs');
			
			$content_tpl->assign('storeddata_nookid', $nookid);
			$content_tpl->assign('module', 'gallery');
			$content_tpl->assign('galleryid', $galleryid);
			
			$list = $galleryObj->getImages($galleryid);			
			if ($list)		
				for ($i=0, $ic = sizeof($list); $i < $ic; $i++)
				{
				
					$list[$i]['imageid'] = $list[$i]['id'];					

					foreach ($CONF['languages'] as $lang){
						$content_tpl->assign('tlang', $lang);
						$content_tpl->assign('imagetitle', $list[$i]['title'][$lang]);
						$content_tpl->parse('main.pics.image.imagetitlerow');
					}						
					
					if ($list[$i]['main']=='1')
						$list[$i]['main']='checked';					
						
					$content_tpl->insert_loop('main.pics.image', $list[$i]);						
	
				}										
			$content_tpl->parse('main.pics');		
		break;
		
		case "uploadimage":	
		
			$galleryid = get_request('galleryid', 0);
			
			$data=array();
			$data['main'] = get_request('main', 0);	
			$data['title'] = get_request('title', null);							
			$data['index'] = get_request('index', 0);				
			$data['videourl'] = get_request('videourl', 0);			
			
			$data['main'] = ($data['main'] === 'on') ? true : false; 
			
			$folders=array();			
			$folders[]=array('folder'=>'slider', 'w'=>1000, 'h'=>450, 'method'=>'resample');						
			$folders[]=array('folder'=>'thumb', 'w'=>100, 'h'=>100, 'method'=>'resample');			
			
			$galleryObj->addImage('uploadedfile', $folders, $galleryid, $data);
			
			/*if (!$data['videourl']){
				$imageObj->uploadImage('uploadedfile', $folders, $nookid, $data);
			} else {
				$imageObj->uploadImage(false, $folders, $nookid, $data);
			}*/
			header('Location: index.php?module=gallery&action=images&galleryid=' . $galleryid);

		break;
		
		case "deleteImage":
			
			$imageid = get_request('imageid', 0);			
			
			$result = $galleryObj->deleteImage($imageid);			
			
			json_headers(
				array(
					'status'	=> $result ? 'OK' : 'FAILURE', 
					'id' 		=> $imageid
				)
			);						
			exit;
		break;		
		
		case 'savegallery':

			$galleryid = get_request('galleryid', false);			
			$data = $_POST['gallery'];					
			if ($galleryid)
				$galleryObj->renameGallery($galleryid, $data);
			else
				$galleryObj->createGallery($data);
			
			header('Location: index.php?module=gallery');
		break;
		
		case 'renameImage':			
			$imageid = $_POST['imageid'];
			$data = array();
			foreach ($_POST['data'] as $lang => $val)
				$data['title'][$lang] = $val;			
			
			$result = $galleryObj->renameImage($imageid, $data);
			
			json_headers(
				array(
					'status' => $result ? 'OK' : 'FAILURE',
					'id'	 => $imageid
				)
			);			
			exit;
		break;
		
		case 'editgallery':
			
			$galleryid = get_request('galleryid', false);
			$content_tpl = new xTemplate($CONF['location'].'apps/standard/tpl/adm/newgallery.html');
			
			if ($galleryid)
			{
				$gallery = $galleryObj->getGalleryById($galleryid);
				$content_tpl->assign('galleryid', $galleryid);				
				$content_tpl->assign('storeddata_module', $gallery['moduleid']);
			}														
			
			for ($i=0; $i<sizeof($CONF['languages']); $i++){
				$content_tpl->assign('lang', $CONF['languages'][$i]);				
				
				if ($galleryid)
				{					
					$content_tpl->assign('storreddata_title', $gallery['title'][$CONF['languages'][$i]]);				
					$content_tpl->assign('storreddata_description', $gallery['description'][$CONF['languages'][$i]]);					
				}
				
				$content_tpl->parse('main.titles');				
				$content_tpl->parse('main.descriptions');
			}
			
		break;
		
		case 'erasegallery':								
			if ($galleryid = get_request('galleryid', false))
				$galleryObj->eraseGallery($galleryid);				
			
			header('Location: '.$CONF['base'].'/adm/index.php?module=gallery');			
		break;
		
		default:
			$content_tpl = new xTemplate($CONF['location'].'apps/standard/tpl/adm/gallery.html');			
			if ($list = $galleryObj->getGalleries())
				for ($i = 0, $ic = sizeof($list); $i < $ic; $i++)
				{	
					$list[$i]['title']=$list[$i]['title'][$CONF['languages'][0]];
					$content_tpl->insert_loop('main.list.item', $list[$i]);			
				}				
			$content_tpl->parse('main.list');			
			
		break;
	}

?>