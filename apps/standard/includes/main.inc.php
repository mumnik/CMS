<?php	

	if (DEBUG)
	{
		set_error_handler("custom_warning_handler", E_NOTICE);
		set_error_handler("custom_warning_handler", E_WARNING);
	}
	
	function SDI($msg='SDI') { 
		echo 'DEBUG INFO: '; var_dump($msg); echo '<br />'; 
	} // DEBUG INFO!!!
	
	function info($msg='SDI') { 
		error($msg); 
	} // error info!!!
	
	function error($msg='SDI') { 
		echo 'ERROR: '; print($msg); echo '<br />'; 
	} // ERROR INFO!!!

	function debug($d){
		echo '<div style="border: 5px solid red; width: 400px; height: 400px; color: #000; background-color: #fff; position: absolute; height: 768px; overflow-y: scroll;">'; 
		echo '<prE>';
		print_r($d);
		echo '</prE>';
		echo '</div>';
	}
	
	function custom_warning_handler($errno, $errstr) {
		echo '<div style="border: 5px solid red; width: 1024px;  color: #000; background-color: #fff; position: absolute; height: 768px; overflow-y: scroll;z-index: 1000000">'; 
		echo '<h2>' . $errstr . '</h2>';
		echo '<pre>';
		print_r(debug_backtrace());		
		echo '</pre>';
		echo '</div>';		
	}
	
	function __autoload($class_name){		
		$class_name = strtolower($class_name);	
		
		if (file_exists(APP_STD . '/classes/' . $class_name . '.class.php'))
			require (APP_STD . '/classes/' . $class_name . '.class.php');
		else if (file_exists(APP_SITE . '/classes/' . $class_name . '.class.php'))
			require(APP_SITE . '/classes/' . $class_name . '.class.php');
		else {
			die('Error: Class "'.$class_name.'" not found');
		}
	}
	
	require_once(APP_STD . '/includes/defines.inc.php');
	require_once(APP_STD . '/includes/func.inc.php');
	require_once(APP_STD . '/includes/db.inc.php');
	require_once(APP_STD . '/includes/lang.inc.php');
	require_once(APP_STD . '/includes/words.inc.php');
	require_once(APP_STD . '/includes/js.inc.php');


	$error = '';
	if(!DBconnect($error)){
		SDI($error);
	}	
