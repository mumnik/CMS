<?php

function getAllTags($type=false){
	$sql = 'select tags from portfolios';
	if ($type){
		$sql.= ' where model="'.$type.'"';
	}
	$res = mysql_query($sql);
	$result = array();
	while ($row = mysql_fetch_assoc($res)){
		$str = explode(',', $row['tags']);
		for ($i=0; $i<sizeof($str); $i++){
			if ($str[$i]!=''){
				if (isset($result[trim($str[$i])])){
					$result[trim($str[$i])]++;
				} else {
					$result[trim($str[$i])] = 1;
				}
			}
		}
	}
	return $result;
}


function countTagSizes($data){

	$tmp = ceil(count($data)/4);	

	$max_size = '28';	
	$min_size = '10';
	
	$step = ceil(($max_size-$min_size)/$tmp);
	
	$intervals = ceil(($max_size-$min_size)/$step);
	
	$min  = PHP_INT_MAX;
	$max = 0;
	foreach ($data as $key=>$val){
		if ($val>$max){
			$max = $val;
		}
		if ($val<$min){
			$min=$val;
		}
	}
	
	//echo 'ints: '.$intervals.'<br>';
	$interval_size = ceil(($max-$min)/$intervals);
	//echo 'isize :'.$interval_size.'<br>';
	//echo 'max :'.$max.'<br>';
	//echo 'min :'.$min.'<br>';
	$result = array();
	
	foreach ($data as $key=>$val){
		$result[]=array('text'=>$key, 'count'=>$val, 'text_size'=>((floor($val/$interval_size)*$step)+$min_size) );
	}
	return $result;
}

function buildTagBox($data){
//	debug($data);
	$result['html'] = '';
	$result['javascript'] = 'var tagarray=new Array;';
	$r = 3;
	
	$result['html'] = '<table id="tagbox">';
	$inarow = 0;
	for ($i=0; $i<count($data); $i++){
		if ($inarow==0){
			$result['html'].='<tr>';
		}		
		$result['html'].='<td style="font-size:'.$data[$i]['text_size'].'px;" id="tag_td_'.$i.'" class="tagNotSelected"><a href="javascript: operatetag(\''.$i.'\');">'.$data[$i]['text'].'</a></td>';
		$result['javascript'].='
			tagarray['.$i.']=new Array;
			tagarray['.$i.'][\'id\']=\''.$i.'\';		
			tagarray['.$i.'][\'text\']=\''.$data[$i]['text'].'\';		
			tagarray['.$i.'][\'selected\']=false;		
		';		
		$inarow++;
		if ($inarow>=$r){
			$result['html'].='</tr>';
			$inarow=0;
		}		
	}
	if (($inarow<$r)&&($inarow!=0)){
		while($inarow<=$r){
			$result['html'].='<td>&nbsp;</td>';
			$inarow++;
		}
		$result['html'].='</tr>';
	}
	$result['html'].='</table>';
	return $result;
}
