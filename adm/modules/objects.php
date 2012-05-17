<?php
	
	$objectObj = new Obj();
	define('OBJ', 'object');
	
	function makeHTypeSelect($sel = false, $lang = false){
	global $CONF, $SITE;
	
		if (!$lang)
			$lang = $CONF['languages'][0];
			
		return makeSelectOptions($SITE['htypes'][$lang], $sel);
	}
	
	function makeSeriesSelect($sel = false, $lang = false){
	global $CONF, $SITE;
	
		if (!$lang)
			$lang = $CONF['languages'][0];
		
		return makeSelectOptions($SITE['series'][$lang], $sel);
	}
	
	function makeTypeSelect($sel = false, $lang = false){
	global $CONF, $SITE;
	
		if (!$lang)
			$lang = $CONF['languages'][0];
		
		return makeSelectOptions($SITE['objecttype'][$lang], $sel);
	}
	
	function makeCitySelect($sel = false){
		$cityObj = new city();
		$listCommon = $cityObj->getList($CONF['languages'][0]);
		
		$list = array();
		foreach ($listCommon as $id =>$val){
			$list[$val['id']]=$val['string'];
		}
		return makeSelectOptions($list, $sel);		
	}
	
	$action = get_request('action',false);
	$id = get_request('id', false);
	
	switch ($action){	
		case 'processedit':
			$data = get_request('data', false);
			
			if ($id)
				$objectObj->edit($id, $data);
			else
				$objectObj->create($data);
				
			header('Location: index.php?module=objects');
			exit;
		break;
		case 'create':
			$content_tpl = new xTemplate( ADMIN_TPL_DIR . '/edit'.OBJ.'.tpl');
			$content_tpl->assign('cityoptions', makeCitySelect()); 
			$content_tpl->assign('seriesoptions', makeSeriesSelect());
			$content_tpl->assign('htypeoptions', makeHTypeSelect());
			$content_tpl->assign('typeoptions', makeTypeSelect());
			
			foreach ($CONF['languages'] as $lang){
				$content_tpl->assign('lang', $lang);
				$content_tpl->parse('main.description');
				$content_tpl->parse('main.street'); 
			}			
		break;
		case 'eraseimage':
			$imageid = get_request('imageid', false);
			if ($imageid)
				$objectObj->removeImage($imageid);			
			
			header('Location: index.php?module=objects&action=gallery&id='.$id);
			exit;
		break;
		case 'changesortindex':
			$imageid = get_request('imageid', false);
			$direction = get_request('direction', false);
			$objectObj->galleryChangeImageSortIndex($imageid, $direction);				
			header('Location: index.php?module=objects&action=gallery&id='.$id);
			exit;
		break;
		case 'setimagemain':
			$imageid = get_request('imageid', false);
			$objectObj->gallerySetImageMain($id, $imageid);
			header('Location: index.php?module=objects&action=gallery&id='.$id);
			exit;
		break;
		case 'renameimage':			
			$imageid = get_request('imageid', false);
			$data = get_request('data');
			$objectObj->galleryRenameImage($imageid, $data);
			header('Location: index.php?module=objects&action=gallery&id='.$id);
			exit;
		break;
		case 'gallery':
			$content_tpl = new xTemplate( ADMIN_TPL_DIR . '/gallery'.OBJ.'.html');
			$content_tpl->assign('id', $id);
			foreach ($CONF['languages'] as $lang){
				$content_tpl->assign('lang', $lang);
				$content_tpl->parse('main.titlelangs.titlelang');				
			}
			$content_tpl->assign('filetoupload', OBJ.'imagefile');			
			$content_tpl->assign('sortindex', $objectObj->getGalleryNextSortIndex($id));			
			$list = $objectObj->getGalleryImages($id);
			//debug($list);
			$content_tpl->parse('main.titlelangs');			
			if (sizeof($list))
				foreach ($list as $key =>$data){
					$data['module'] = $module; //???
					if ($data['main'])
						$data['main'] = 'checked=checked';
					
					foreach ($CONF['languages'] as $lang){
						
						$content_tpl->assign('lang', $lang);	
						if (isset($data['title'][$lang]))						
							$content_tpl->assign('imagetitle', $data['title'][$lang]);						
						$content_tpl->parse('main.pics.image.imagetitlerow');						
					}
					$content_tpl->assign('data', $data);
					$content_tpl->parse('main.pics.image');
				}
			$content_tpl->parse('main.pics');			
		break;
		case 'uploadimage':
			$data = $_POST['data'];
			$objectObj->addImage($id, $data);
			//debug($data);
			header('Location: index.php?module=objects&action=gallery&id='.$id);
			exit;			
		break;
		case 'edit':		

			$content_tpl = new xTemplate( ADMIN_TPL_DIR . '/edit'.OBJ.'.tpl');
			
			$obj = $objectObj->get($id);
			$content_tpl->assign('cityoptions', makeCitySelect($obj['cityid']));
			$content_tpl->assign('seriesoptions', makeSeriesSelect($obj['series']));
			$content_tpl->assign('typeoptions', makeTypeSelect($obj['objecttype']));
			$content_tpl->assign('htypeoptions', makeHTypeSelect($obj['htype']));
			
			foreach ($CONF['languages'] as $lang){
				$content_tpl->assign('lang', $lang);				
				$content_tpl->assign('description', $obj['descriptionstring']);
				$content_tpl->assign('street', $obj['streetstring']);
				$content_tpl->parse('main.description');
				$content_tpl->parse('main.street');
			}
			$content_tpl->assign('data', $obj);
			
			//header('Location: index.php?module=objects&action=gallery&id='.$id);			
			//exit;
		break;
		case 'erase':
			$id = $_GET['id'];
			$objectObj->erase($id);
			
			header('Location: index.php?module=objects');
			exit;
		break;
		default:
			$content_tpl = new xTemplate( ADMIN_TPL_DIR . '/'.OBJ.'list.tpl');
			$list = $objectObj->getList();
			foreach ($list as $data){
				$content_tpl->assign('id', $data['id']);
				$content_tpl->assign('data', $data);
				$content_tpl->parse('main.'.OBJ.'s.'.OBJ);
			}
		
			$content_tpl->parse('main.'.OBJ.'s');
		break;
	}