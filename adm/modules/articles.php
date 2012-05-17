<?php

	$articleObj = new article();	

	$action = get_request('action', false);	

	switch ($action){
		case "savearticle":
			$nookid = get_request('nookid', 0);
			$data = $articleObj->createNookDataArrayPrepare(get_request('article', false));
			
			if ($data){
				if ($nookid>0){
					$articleObj->saveArticle($nookid, $data);
				} else {					
					$articleObj->createArticle($data);
				}
			}
			//exit;
			header('Location: index.php?module=articles');
		break;
		case "images":
			$nookid = get_request('nookid', 0);
			
			$imagesObj = new image();
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/nook_images.tpl');

			$content_tpl->assign('storeddata_nookid', $nookid);
			$content_tpl->assign('module', 'articles');
			
			$list = $imagesObj->getImagesByParentNookId($nookid);
			
			if ($list){
				for ($i=0; $i<sizeof($list); $i++){
					$content_tpl->insert_loop('main.pics.prow', $list[$i]);	
				}
				$content_tpl->parse('main.pics');		
			}
		break;
		case "uploadimage":
			
			$imageObj = new image();
			$nookid = get_request('nookid', 0);
			$data=array();
			$data['main'] = get_request('main', 0);				
			
			$folders=array();
			$folders[]=array('folder'=>'small', 'w'=>100, 'h'=>200, 'method'=>'resample');
			$folders[]=array('folder'=>'thumbs', 'w'=>50, 'h'=>50, 'method'=>'resample');
			$imageObj->uploadImage('uploadedfile', $folders, $nookid);
			
			header('Location: index.php?module=articles&action=images&nookid='.$nookid);
		break;
		case "eraseimage":
			$imageObj = new image();
			$nookid = get_request('nookid', 0);
			$returnnookid = get_request('returnnookid', 0);
			$imageObj->deleteImage($nookid);
			
			header('Location: index.php?module=articles&action=images&nookid='.$returnnookid);
		break;		
		case "editarticle":
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/articleedit.tpl');
			$nookid = get_request('nookid', 0);
			$data = $articleObj->getNookById($nookid);
			
			foreach ($data as $key=>$val){
				$content_tpl->assign('storeddata_'.$key, $val);	
			}
		break;
		case "createarticle":
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/articleedit.tpl');
			$content_tpl->assign('storeddata_nookid', 0);
		break;
		
		case "erasearticle":
			$nookid = get_reauest('nookid', 0);
			$productsObj->deleteNook($nookid);
			
			header('Location: index.php?module=articles');

		break;
		
		default:
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/articles.tpl');
			$list = $articleObj->getArticles();
		//	debug($list);
			if ($list){
				for ($i=0; $i<sizeof($list); $i++){
					$content_tpl->insert_loop('main.articlelist.article', $list[$i]);	
				}	
				$content_tpl->parse('main.articlelist');
			}
		break;
	}

?>