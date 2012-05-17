<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

/* function:
 *     cms_jsvalue
 *
 * description:
 *	convert PHP variable to string version
 *      of JavaScrip style 
 *
 * author: Eugene Grigorjev
 */
function cms_jsvalue($value){
	if(!is_array($value)) {
		if(is_object($value)) return unpack_object($value);
		if(is_string($value)) return '\''.str_replace('\'','\\\'',			/*  '	=> \'	*/
							str_replace("\n", '\n', 		/*  LF	=> \n	*/
								str_replace("\\", "\\\\", 	/*  \	=> \\	*/
									str_replace("\r", '', 	/*  CR	=> remove */
										($value))))).'\'';
		if(is_null($value)) return 'null';
	return strval($value);
	}

	if(count($value) == 0) return '[]';

	foreach($value as $id => $v){
		if(!isset($is_object) && is_string($id)) $is_object = true;
		$value[$id] = (isset($is_object) ? '\''.$id.'\' : ' : '').cms_jsvalue($v);
	}

	if(isset($is_object))
		return '{'.implode(',',$value).'}';
	else
		return '['.implode(',',$value).']';
}

/* function:
 *     cms_add_post_js
 *
 * description:
 *	add JavaScript for calling after page loaging.
 *
 * author: Eugene Grigorjev
 */
function cms_add_post_js($script){
	global $cms_PAGE_POST_JS;

	$cms_PAGE_POST_JS[] = $script;
}

function js_redirect($url,$timeout=null){
	cms_flush_post_cookies();

	if( is_numeric($timeout) ) { 
		$script.='setTimeout(\'window.location="'.$url.'"\','.($timeout*1000).')';
	} 
	else {
		$script.='window.location = "'.$url.'";';
	}
	insert_js($script);
}

function simple_js_redirect($url,$timeout=null){
	$script = '';
	if( is_numeric($timeout) ) { 
		$script.='setTimeout(\'window.location="'.$url.'"\','.($timeout*1000).')';
	} 
	else {
		$script.='window.location = "'.$url.'";';
	}
	insert_js($script);
}

function alert($msg){
	insert_js('alert("'.$msg.'");');
}

function insert_js($script){
print('<script type="text/javascript"><!--'."\n".$script."\n".'--></script>');
}
?>
