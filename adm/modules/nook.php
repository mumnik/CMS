<?php

	$action = get_request('action', 'list');

	function makedatatypeselectoroptions($sel=false){
		$fields = enum("nookfields.type");
		$result='';
		for($i=0; $i<sizeof($fields);$i++){
			if ($fields[$i]==$sel){
				$selected='selected';
			} else {
				$selected='';
			}
			$result.='<option value="'.$fields[$i].'" '.$selected.'>'.$fields[$i].'</option>'."\n";
		}
		return $result;
	} 
	
	function makelangdependentselectoroptions($sel=false){
		if (!$sel){
			$result='
				<option value="0" selected>false</option>
				<option value="1">true</option>
			';
		} else {
			$result='
				<option value="0">false</option>
				<option value="1" selected>true</option>
			';
		}
		return $result;
	}
	
	 
	switch ($action){
		case "editnooktype":
		
			$nookid = get_request('nookid', 0);
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/editnook.tpl');
			
			$sql = 'select * from nooktypes where id = "'.$nookid.'"';
			$res = DBselect($sql);
			$row = DBfetch($res);
			$content_tpl->assign('title', $row['title']);
			$content_tpl->assign('nookid', $nookid);
			
			$sql = 'select * from nookfields where nooktypeid="'.$nookid.'" order by field';
			$res = DBselect($sql);
			
			while ($row = mysql_fetch_assoc($res)){
				$row['defaultvalue']=htmlentities($row['defaultvalue'], ENT_QUOTES);
				$row['datatypeselectoroptions']=makedatatypeselectoroptions($row['type']);
				$row['langdependentselectoroptions']=makelangdependentselectoroptions($row['langdependent']);
				$content_tpl->insert_loop('main.nookfields.nookfield',$row);
			}
			$content_tpl->parse('main.nookfields');			
			$content_tpl->assign('datatypeselectoroptionsclean',makedatatypeselectoroptions());
			$content_tpl->assign('langdependentselectoroptionsclean',makelangdependentselectoroptions());
		
		break;
		case "savenooktype":
			$nookid = get_request('nookid', false);
			$nook = get_request('nook', false);
			if (($nookid)&&($nook)){
				$sql = 'delete from nookfields where nooktypeid="'.$nookid.'"';
				DBexecute($sql);
				foreach ($nook['fields'] as $key=>$val){
					if (($val['title']!='')&&($val['type']!='')){
						$sql = 'insert into nookfields 
								set nooktypeid="'.$nookid.'",
								field="'.$val['title'].'",
								type="'.$val['type'].'",
								defaultvalue="'.mysql_escape_string($val['defaultvalue']).'",
								langdependent="'.$val['langdependent'].'"';						
						DBexecute($sql);
					}
				}
			}
			header('Location: index.php?module=nooks&action=editnooktype&nookid='.$nookid);
		break;
		case "createnookfield":
			$nookid = get_request('nookid', false);
			$field = get_request('field', false);
			if (($field)&&($nookid)){
				if ($field['title']!=''){
					$sql = 'insert into nookfields set field="'.$field['title'].'", type="'.$field['type'].'", langdependent="'.$field['langdependent'].'", nooktypeid="'.$nookid.'", defaultvalue="'.mysql_escape_string($field['defaultvalue']).'"';
					DBexecute($sql);					
				}
			}
			header('Location: index.php?module=nooks&action=editnooktype&nookid='.$nookid);
		break;


		case "createnooktype":
					$field = get_request('field', false);

				if ($field['title']!='')
					{
					$sql = 'insert into nooktypes set title="'.$field['title'].'"';
					DBexecute($sql);				
					}			
			//debug($field);
			//exit;
			header('Location: index.php?module=nooks');
		break;

		case "erasenooktype":
			$nookid = get_request('nookid', false);
			if ($nookid)
			{

				$sql3 = 'delete from nookdata where nookid in (select id from nooks where nooktypeid = "'.$nookid.'")';
				DBexecute($sql3);

				$sql2 = 'delete from nookfields where nooktypeid="'.$nookid.'"';
				DBexecute($sql2);

				$sql1 = 'delete from nooks where nooktypeid="'.$nookid.'"';
				DBexecute($sql1);

				$sql = 'delete from nooktypes where id="'.$nookid.'"';
				DBexecute($sql);
			}

			header('Location: index.php?module=nooks');
			
		
		break;
		case "erasenookfield":
			$fieldid = get_request('fieldid', false);
			if ($fieldid){
				$sql = 'select * from nookfields where id="'.$fieldid.'"';
				$res = DBselect($sql);
				$row = DBfetch($res);
				$nooktype = $row['nooktypeid'];
				$sql = 'delete from nookfields where id="'.$fieldid.'"';
				DBexecute($sql);
			}
			header('Location: index.php?module=nooks&action=editnooktype&nookid='.$row['nooktypeid']);	
		break;
		default:
			$content_tpl = new xTemplate($CONF['location'].'/tpl/adm/nooks.tpl');
			$sql = 'select * from nooktypes';
			$res = DBselect($sql);
			while ($row = DBfetch($res)){
				$content_tpl->insert_loop('main.nooktypes.nooktype', $row);
			}
			$content_tpl->parse('main.nooktypes');
		break;
	
	}

?>