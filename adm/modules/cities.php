<?php
	
	
	$cityObj = new city();
	
	define('DEBUG', true);		
	
	function makeDistrictSelect($sel=false){	
		$districtObj = new district();
		$listCommon = $districtObj->getList($CONF['languages'][0]);
		$list = array();
		foreach ($listCommon as $id =>$val){
			$list[$val['id']]=$val['string'];
		}
		return makeSelectOptions($list, $sel);		
	}
	
	$action = $_GET['action'];
	switch ($action){
		case 'processeditcity':
			$data = $_POST['data'];
			$id = $_GET['cityid'];
			if (!$id){
				$cityObj->createCity($data);
			} else {
				$cityObj->renameCity(array('id'=>$id, 'title'=>$data['title'], 'district'=>$data['district']));
			}
			header('Location: index.php?module=cities');
		break;
		case 'editcity':
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . '/editcity.tpl');
			$id = $_GET['cityid'];
			$city = $cityObj->getCity($id);	
			
			$content_tpl->assign('id', $city['id']);
			foreach ($CONF['languages'] as $language){
				$content_tpl->assign('language', $language);
				$content_tpl->assign('title', $city['title'][$language]);
				$content_tpl->parse('main.city.title');
			}			
			$content_tpl->assign('districtoptions', makeDistrictSelect($city['districtid']));
			$content_tpl->parse('main.city');
		break;
		case 'createcity':
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . '/editcity.tpl');
			foreach ($CONF['languages'] as $language){
				$content_tpl->assign('language', $language);			
				$content_tpl->parse('main.city.title');
			}
			$content_tpl->assign('districtoptions', makeDistrictSelect());
			$content_tpl->parse('main.city');
		break;
		case 'erasecity':
			$id = $_GET['cityid'];
			$cityObj->eraseCity($id);
			header('Location: index.php?module=cities');
		break;
		default: 
			$list = $cityObj->getList('all');		
			if (DEBUG)
				var_dump($list);
			$content_tpl = new xTemplate(ADMIN_TPL_DIR . '/citieslist.tpl');
			foreach ($list as $id=>$data){
				$content_tpl->assign('title', $data['title'][$CONF['languages'][0]]);
				$content_tpl->assign('id', $id);
				$content_tpl->parse('main.cities.city');
			}
			$content_tpl->parse('main.cities');
		break;
	}
	