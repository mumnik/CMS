<?php
	
	
	$districtObj = new district();
	
	define('DEBUG', true);	
	
	$action = $_GET['action'];
	switch ($action){
		case 'processeditdistrict':
			$data = $_POST['data'];
			$id = $_GET['districtid'];
			if (!$id){
				$districtObj->createdistrict($data);
			} else {
				$districtObj->renamedistrict(array('id'=>$id, 'title'=>$data['title']));
			}
			header('Location: index.php?module=districts');
		break;
		case 'editdistrict':
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . '/editdistrict.tpl');
			$id = $_GET['districtid'];
			$district = $districtObj->getdistrict($id);		
			$content_tpl->assign('id', $district['id']);
			foreach ($CONF['languages'] as $language){
				$content_tpl->assign('language', $language);
				$content_tpl->assign('title', $district['title'][$language]);
				$content_tpl->parse('main.district.title');
			}
			$content_tpl->parse('main.district');
		break;
		case 'createdistrict':
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . '/editdistrict.tpl');
			foreach ($CONF['languages'] as $language){
				$content_tpl->assign('language', $language);			
				$content_tpl->parse('main.district.title');
			}
			$content_tpl->parse('main.district');
		break;
		case 'erasedistrict':
			$id = $_GET['districtid'];
			$districtObj->erasedistrict($id);
			header('Location: index.php?module=districts');
		break;
		default: 
			$list = $districtObj->getList('all');		
			if (DEBUG)
				var_dump($list);
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . '/districtslist.tpl');
			foreach ($list as $id=>$data){
				$content_tpl->assign('title', $data['title'][$CONF['languages'][0]]);
				$content_tpl->assign('id', $id);
				$content_tpl->parse('main.districts.district');
			}
			$content_tpl->parse('main.districts');
		break;
	}
	