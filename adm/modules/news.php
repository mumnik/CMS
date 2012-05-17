<?php

	$newsObj = new news();
	$action = get_request('action', false);	

	switch ($action){
		case "savenews":
			$nookid = get_request('nookid', 0);
			$data = $newsObj->createNookDataArrayPrepare(get_request('news', false));
		//	debug($data);
			if ($data){
				if ($nookid>0){
					$newsObj->saveNews($nookid, $data);
				} else {					
					$newsObj->createNews($data);
				}
			}
			//exit;
			header('Location: index.php?module=news');
		break;

		case "images":
			$nookid = get_request('nookid', 0);
			$imagesObj = new image();
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/news_images.tpl');
			$content_tpl->assign('storeddata_nookid', $nookid);
			$content_tpl->assign('module', 'news');
			$list = $imagesObj->getImagesByParentNookId($nookid);

			
			
			if ($list){
				$q = 0;
				for ($i=0; $i<sizeof($list); $i++){
					$list[$i]['title']=$list[$i]['title'][$CONF['languages'][0]];
					$content_tpl->insert_loop('main.pics.prow.image', $list[$i]);	
					if ((($i+1)%6)==0){
						$content_tpl->parse('main.pics.prow', $list[$i]);	
					}	
					$q = $i;
				}			
				if ((($q+1)%6)!=0){
					for ($i = $q; (($i+1)%6==0); $i++){
						$content_tpl->insert_loop('main.pics.prow.image', $list[$i]);	
					}
				}
				$content_tpl->parse('main.pics.prow', $list[$i]);	
				$content_tpl->parse('main.pics');		
			}
		break;

		case "images":
			$nookid = get_request('nookid', 0);
			$commentObj = new comment();
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/news_comment.tpl');
			$content_tpl->assign('storeddata_nookid', $nookid);
			$content_tpl->assign('module', 'news');
			$list = $commentObj->getCommentByParentNookId($nookid);

			if ($list){
				for ($i=0; $i<sizeof($list); $i++){
					$content_tpl->insert_loop('main.comment.prow', $list[$i]);	
				}
				$content_tpl->parse('main.comment');		
			}
		break;

		case "uploadimage":
			$imageObj = new image();
			$nookid = get_request('nookid', 0);
			$data=array();
			$data['main'] = get_request('main', 0);				
			$data['index'] = get_request('index', 0);				

			$folders=array();

			$folders[]=array('folder'=>'newsimages', 'w'=>624, 'h'=>238, 'method'=>'cropresample');
			$folders[]=array('folder'=>'small', 'w'=>800, 'h'=>600, 'method'=>'resample');
			$folders[]=array('folder'=>'newsthumbs', 'w'=>71, 'h'=>71, 'method'=>'cropresample');
			$folders[]=array('folder'=>'thumbs', 'w'=>128, 'h'=>128, 'method'=>'crop');					
			$folders[]=array('folder'=>'gallerymainimages', 'w'=>448, 'h'=>370, 'method'=>'cropresample');
			/*$folders[]=array('folder'=>'gallerythumbsmain', 'w'=>68, 'h'=>68, 'method'=>'cropresample');*/
		
			$imageObj->uploadImage('uploadedfile', $folders, $nookid, $data);

			header('Location: index.php?module=news&action=images&nookid='.$nookid);
		break;

		case "eraseimage":
			$imageObj = new image();
			$nookid = get_request('nookid', 0);
			$returnnookid = get_request('returnnookid', 0);
			$imageObj->deleteImage($nookid);
	
			header('Location: index.php?module=news&action=images&nookid='.$returnnookid);
		break;		

		case "editnews":
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/newsedit.tpl');
			$nookid = get_request('nookid', 0);
			$data = $newsObj->getNookById($nookid);

			//debug($data);
			/*foreach ($data as $key=>$val){
				$content_tpl->assign('storeddata_'.$key, $val);	
			}*/			

			$content_tpl->assign('storeddata_nookid', $nookid);	

			if ($nookid){
				$content_tpl->assign('storeddata_date', $data['date']);	
			} else {
				$content_tpl->assign('storeddata_date', date('d.m.Y'));
			}

			$textareas=array();
			foreach ($data as $key=>$val){
				if (($key=='time')||($key=='nookid')||($key=='date')||($key=='type')){
					continue;
				}

				if ($newsObj->fieldlist[$key]['langdependent']){				
					for ($i=0; $i<sizeof($CONF['languages']); $i++){
						$content_tpl->assign('title', $key);
						$content_tpl->assign('fieldlang', $CONF['languages'][$i]);
						if ($newsObj->fieldlist[$key]['type']=='txt'){
							$content_tpl->assign('input', '<textarea name="news['.$key.']['.$CONF['languages'][$i].']" id="textarea_'.sizeof($textareas).'">'.$val[$CONF['languages'][$i]].'</textarea>');	
							$textareas[]='textarea_'.sizeof($textareas);
						} else {
							$content_tpl->assign('input', '<input type="text" name="news['.$key.']['.$CONF['languages'][$i].']" value="'.$val[$CONF['languages'][$i]].'" class="inp-form">');						
						}
					
						$content_tpl->parse('main.fields.field');
					}
				} else {
					$content_tpl->assign('title', $key);
					$content_tpl->assign('fieldlang', '-');
					$content_tpl->assign('input', '<input type="text" name="news['.$key.']" value="'.$val.'">');
					$content_tpl->parse('main.fields.field');
				}
			}

			$content_tpl->parse('main.fields');
			$content_tpl->assign('textareas', implode(', ', $textareas));
		break;

		case "createnews":
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/newsedit.tpl');
			$content_tpl->assign('storeddata_nookid', 0);
			$content_tpl->assign('storeddata_date', date('d.m.Y'));
		break;

		case "erasenews":
			$nookid = get_request('nookid', 0);
			$newsObj->deleteNook($nookid);

			header('Location: index.php?module=news');
		break;

		default:
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/news.tpl');
			$list = $newsObj->getNews();
			usort($list, 'compare_dates');

			if ($list){
				for ($i=0; $i<sizeof($list); $i++){
					$list[$i]['title']=$list[$i]['title'][$CONF['languages'][0]];
					$content_tpl->insert_loop('main.newslist.news', $list[$i]);
				}	

				$content_tpl->parse('main.newslist');
			}
		break;
	}
?>