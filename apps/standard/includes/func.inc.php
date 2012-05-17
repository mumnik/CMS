<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

function redirect(){
global $CONF;	
	header("Location: ".$CONF['base']);
}

function comparenookimagetitles($a, $b){
	if($a['file']<$b['file'])
		return false;
	else 
		return true;	
}		

function comparekeys($a, $b){
		if (key($a)>key($b)){
			return true;
		} else {
			return false;
		}
	}

function comparefiles($a, $b){
	return strcmp($a['title'], $b['title']);
}


function json_headers($data = false)
{
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: '. date('D, j M G:i:s Y').' GMT');
	header('Content-type: application/json');
	
	if ($data)
		die(json_encode($data));		
}

function getLastestImages($folder = false, $count = false){
global $CONF;

	function compareimages($a, $b){
		if ($a['title']<$b['title']){
			return true;
		} else {
			return false;
		}
	}

	if (!$folder)
		$folder = 'thumbs';		
	
	
	$files = false;
	if ($handle = opendir($folder)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$p = strpos($file, '.');
				
				if ($p){
					$files[]=array('folder'=>$folder,'title'=>substr($file, 0 , $p), 'extention'=>substr($file, $p+1 , strlen($file)-$p));
				} else {
					$files[]=array('folder'=>$folder, 'title'=>$file, 'extention'=>'');
				}
			}
		}
		closedir($handle);
	}
	if ($files){
		usort($files, 'compareimages');	
		if ($count)
			$files = array_slice($files, 0, $count);	
	}
	return $files;
}



function isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

/************* DYNAMIC REFRESH *************/


function getDaysInBetween($interval){ 
	//debug($interval);
	$secinminute = 60;
	$secinhour = 3600;
	$secinday = 86400;
	
	$result=array('days'=>0, 'hours'=>0, 'minutes'=>0, 'seconds'=>0);
	
	$result['days']=floor($interval/$secinday);
	$interval-=$result['days']*$secinday;
	$result['hours']=floor($interval/$secinhour);
	$interval-=$result['hours']*$secinhour;
	$result['minutes']=floor($interval/$secinminute);
	$interval-=$result['minutes']*$secinminute;
	$result['seconds']=$interval;

	return $result;
} 

function getSecontsBetween($start, $end){ 		
	$res = strtotime($end)-strtotime($start);	
	if ($res<=0){
		return false;
	}
	return $res;
} 


function compare_dates($a, $b){
	$a=strtotime($a['date']);
	$b=strtotime($b['date']);
	if ($a<$b){
		return true;
	}
	return false;
}

function add_doll_objects($ref_tab, $pmid='mainpage'){	
	$upd_script = array();
	foreach($ref_tab as $id => $doll){
		$upd_script[$doll['id']] = format_doll_init($doll);
	}				
	cms_add_post_js('initPMaster('.cms_jsvalue($pmid).','.cms_jsvalue($upd_script).');');
}


function makeSelectOptions($list, $sel = false){
    $result = '';
    foreach ($list as $id=>$val){
		$result.= '<option value="'.$id.'" '.(($id==$sel)?'selected':'').'>'.$val.'</option>'."\n";
    }
    return $result;
}

function makeSelectFromJSON($data, $sel = false){
	$data = json_decode($data);
	makeSelectOptions($data, $sel);
	return $options;
}

function enum($object) {
	
	// NOOK TYPES ARE STORED IN DB IN ENUM FIELD PROPERTIES!!!
	
	list($table, $col) = explode(".", $object);
	$sql = "SHOW COLUMNS FROM `".$table."` LIKE '".$col."'";

	$row=@mysql_fetch_assoc(mysql_query($sql));
	return ($row ? explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row['Type'])) : array(0=>'None'));
	
}

function sendHTMLEmail($from, $to, $subject, $body){
	
	$boundary = '-----=' . md5( uniqid ( rand() ) ); 
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
	$headers .= 'Content-type: text/html; charser="utf-8"' . "\r\n";
	$headers .= "From: $from\r\nReply-To: $from";
	
	$message = $body;

		
	return  @mail( $to, $subject, $message, $headers );
	
}

function sendEmail($to, $subject, $body){ // add from?
global $config;

	return sendHTMLEmail($to, $subject, $body);
	
}

function truncatetext($text, $place){
	if ($place>=strlen($text)){
		return $text;
	}
	
	$delimiters=array(' ', ',', '.', "\n", "\t", '!', '?', ':');
	
	while (($place<strlen($text))&&(!in_array($text[$place], $delimiters))){
		$place++;
	} 
	return substr($text, 0, $place).'...';
}

function format_doll_init($doll){
	global $USER_DETAILS;
	
	$args = array('frequency' => 60,
					'url' => '',
					'counter' => 0,
					'darken' => 0,
					'params' => array()
				);
	
	foreach($args as $key => $def){
		if(isset($doll[$key])) $obj[$key] = $doll[$key];
		else $obj[$key] = $def;
	}
	
	$obj['url'].= (cms_empty($obj['url'])?'?':'&').'output=html';
	
	$obj['params']['favobj'] = 'refresh';
	$obj['params']['favid'] = $doll['id'];
	
return $obj;
}


function get_update_doll_script($pmasterid, $dollid, $key, $value=''){
	$script = 'PMasters['.cms_jsvalue($pmasterid).'].dolls['.cms_jsvalue($dollid).'].'.$key.'('.cms_jsvalue($value).');';
return $script;
}

function make_refresh_menu($pmid,$dollid,$cur_interval,$params=null,&$menu,&$submenu){

	$menu['menu_'.$dollid][] = array(S_REFRESH, null, null, array('outer'=> array('pum_oheader'), 'inner'=>array('pum_iheader')));
	$intervals = array('10','30','60','120','600','900');
	
	foreach($intervals as $key => $value){
		$menu['menu_'.$dollid][] = array(
					S_EVERY.SPACE.$value.SPACE.S_SECONDS_SMALL, 
					'javascript: setRefreshRate('.cms_jsvalue($pmid).','.cms_jsvalue($dollid).','.$value.','.cms_jsvalue($params).');'.
					'void(0);',	
					null, 
					array('outer' => ($value == $cur_interval)?'pum_b_submenu':'pum_o_submenu', 'inner'=>array('pum_i_submenu')
			));
	}
	$submenu['menu_'.$dollid][] = array();
}

/************* END REFRESH *************/

/************ REQUEST ************/
function get_request($name, $def=null, $type=null){
	if(isset($_REQUEST[$name]))
		$var = $_REQUEST[$name];
	else
		return $def;
	
	if(!isset($type)) return $var;
	
//	function check_type(&$field, $flags, &$var, $type){
	if($type == T_INT_RANGE){
		if(!is_int_range($var) ){
			info('Warning. Field ['.$name.'] is not integer range');
			return $def;
		}
		return $var;
	}
	
	if(($type == T_ID) && !cms_ctype_digit($var)) {
		info('Warning. Field ['.$name.'] is not id');
		return $def;
	}
	
	if(($type == T_INT) && !is_numeric($var)) {
		info('Warning. Field ['.$name.'] is not integer');
		return $def;
	}

	if(($type == T_DBL) && !is_numeric($var)) {
		info('Warning. Field ['.$name.'] is not double');
		return $def;
	}

	if(($type == T_STR) && !is_string($var)) {
		info('Warning. Field ['.$name.'] is not string');
		return $def;
	}

	if(($type == T_CLR) && !is_hex_color($var)) {
		$var = 'FFFFFF';
		info('Warning. Field ['.$name.'] is not color');
		return $def;
	}
	return $var;
}

function inarr_isset($keys, $array=null){
	if(is_null($array)) $array =& $_REQUEST;

	if(is_array($keys)){
		foreach($keys as $id => $key){
			if( !isset($array[$key]) )
				return false;
		}
		return true;
	}

	return isset($array[$keys]);
}
/************ END REQUEST ************/

/************ COOKIES ************/
/* function:
 *      get_cookie
 *
 * description:
 *      return cookie value by name,
 *      if cookie is not present return $default_value.
 *
 * author: Eugene Grigorjev
 */
function get_cookie($name, $default_value=null){
	if(isset($_COOKIE[$name]))	return $_COOKIE[$name];
	// else
	return $default_value;
}

/* function:
 *      cms_setcookie
 *
 * description:
 *      set cookies.
 *
 * author: Eugene Grigorjev
 */
function cms_setcookie($name, $value, $time=null){
	setcookie($name, $value, isset($time) ? $time : (0));
	$_COOKIE[$name] = $value;
}

/* function:
 *      cms_unsetcookie
 *
 * description:
 *      unset and clear cookies.
 *
 * author: Aly
 */
function cms_unsetcookie($name){
	cms_setcookie($name, null, -99999);
	unset($_COOKIE[$name]);
}

/* function:
 *     cms_flush_post_cookies
 *
 * description:
 *     set posted cookies.
 *
 * author: Eugene Grigorjev
 */
function cms_flush_post_cookies($unset=false){
	global $cms_PAGE_COOKIES;

	if(isset($cms_PAGE_COOKIES)){
		foreach($cms_PAGE_COOKIES as $cookie){
			if($unset)
				cms_unsetcookie($cookie[0]);
			else
				cms_setcookie($cookie[0], $cookie[1], $cookie[2]);
		}
		unset($cms_PAGE_COOKIES);
	}
}

/* function:
 *      cms_set_post_cookie
 *
 * description:
 *      set cookies after authorisation.
 *      require calling 'cms_flush_post_cookies' function
 *	Called from:
 *         a) in 'include/page_header.php'
 *         b) from 'redirect()'
 *
 * author: Eugene Grigorjev
 */
function cms_set_post_cookie($name, $value, $time=null){
	global $cms_PAGE_COOKIES;

	$cms_PAGE_COOKIES[] = array($name, $value, isset($time)?$time:0);
}

/************ END COOKIES ************/

/************* DATE *************/
/* function:
 *      cms_date2age
 *
 * description:
 *      Calculate and convert timestamp to string representation. 
 *
 * author: Aly
 */
function cms_date2age($start_date,$end_date=0,$utime = false){

	if(!$utime){
		$start_date=date('U',$start_date);
		if($end_date)
			$end_date=date('U',$end_date);
		else
			$end_date = time();
	}

	$time = abs($end_date-$start_date);
//SDI($start_date.' - '.$end_date.' = '.$time);

	$years = (int) ($time / (365*86400));
	$time -= $years*365*86400;

	//$months = (int ) ($time / (30*86400));
	//$time -= $months*30*86400;
	 
	$weeks = (int ) ($time / (7*86400));
	$time -= $weeks*7*86400;
	 
	$days = (int) ($time / 86400);
	$time -= $days*86400;
	
	$hours = (int) ($time / 3600);
	$time -= $hours*3600;
	
	$minutes = (int) ($time / 60);
	$time -= $minutes*60;
	
	if($time >= 1){
		$seconds = round($time,2);
		$ms = 0;
	}
	else{
		$seconds = 0;
		$ms = round($time,3) * 1000;
	}
	
	$str =  (($years)?$years.'y ':'').
//			(($months)?$months.'m ':'').
			(($weeks)?$weeks.'w ':'').
			(($days)?$days.'d ':'').
			(($hours && !$years)?$hours.'h ':'').
			(($minutes && !$years && !$weeks)?$minutes.'m ':'').			
			((!$years && !$weeks && !$days && (!$ms || $seconds))?$seconds.'s ':'').			
			(($ms && !$years && !$weeks && !$days && !$hours)?$ms.'ms':'');return $str;
}

function getmicrotime(){
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
}

/************* END DATE *************/


/*************** CONVERTING ******************/
function rgb2hex($color){			
	$HEX = array(
		dechex($color[0]),
		dechex($color[1]),
		dechex($color[2])
	);
	
	foreach($HEX as $id => $value){
		if(strlen($value) != 2) $HEX[$id] = '0'.$value;
	}
	
return $HEX[0].$HEX[1].$HEX[2];
}
/*************** END CONVERTING ******************/

/*************** HTML ******************/
function make_decoration($haystack, $needle, $class=null){
	$result = $haystack;

	$pos = stripos($haystack,$needle);
	if($pos !== FALSE){
		$start = cms_substring($haystack, 0, $pos);
//			$middle = substr($haystack, $pos, zbx_strlen($needle));
		$middle = $needle;
		$end = substr($haystack, $pos+zbx_strlen($needle));

		if(is_null($class)){
			$result = array($start, bold($middle), $end);
		}
		else{
			$result = array($start, new CSpan($middle, $class), $end);
		}
	}

return $result;
}
/*************** END HTML ******************/

/************* CMS MISC *************/

function cms_empty($value){
	if(is_null($value)) return true;		
	if(is_array($value) && empty($value)) return true;
	if(is_string($value) && ($value === '')) return true;
return false;
}

function cms_ctype_digit($x){ 
	return preg_match('/^\\d+$/',$x);
}

function cms_numeric($value){
	if(is_array($value)) return false;
	if(cms_empty($value)) return false;
	
	$value = strval($value);

return preg_match('/^[-|+]?\\d+$/',$value);
}

function strleft($s1, $s2) { 
	return substr($s1, 0, strpos($s1, $s2)); 
}

function cms_nl2br(&$str){
	$str_res = array();
	$str_arr = explode("\n",$str);
	foreach($str_arr as $id => $str_line){
		array_push($str_res,$str_line,BR());
	}
return $str_res;
}

function cms_value2array(&$values){
	if(!is_array($values) && !is_null($values)){
		$tmp = array();
		$tmp[$values] = $values;
		$values = $tmp;
	}
}

function cms_substring($haystack, $start, $end=null){
	if(!is_null($end) && ($end < $start)) return '';

	if(is_null($end))
		$result = substr($haystack, $start);
	else
		$result = substr($haystack, $start, ($end - $start));

return $result;
}

function selectByPattern(&$table, $column, $pattern, $limit){
	$rsTable = array();
	foreach($table as $num => $row){
		if($row[$column] == $pattern)
			$rsTable = array($num=>$row) + $rsTable;
		else if($limit > 0)
			$rsTable[$num] = $row;
		else
			continue;

		$limit--;
	}

	if(!empty($rsTable)){
		$rsTable = array_chunk($rsTable, $limit, true);
		$rsTable = $rsTable[0];
	}

return $rsTable;
}
/************* END CMS MISC *************/

?>