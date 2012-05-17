<?php	

	global $CONF;
	
	// DATABASE
	//=====================================================
	$CONF['dbtype']		= 'MYSQL';
	$CONF['dbserver']	= 'localhost';
	$CONF['dbport']		= '';	// default
	
	$CONF['dbase']		= 'c2web';
	$CONF['dbuser']		= 'c2web';
	$CONF['dbpass']		= 'f00tb4ll';
	
	//=====================================================
	
	$CONF['base']			= 'http://www.isealatvia.com';
	$CONF['location']		= '/var/www/isealatvia.com/web/';	
	$CONF['title']			= 'ISEA';
	$CONF['charset']		= 'UTF-8';
	$CONF['default']		= 'main'; //default module
	$CONF['adm_login']		= 'okna';
	$CONF['adm_pass']		= 'okna';
	$CONF['languages']		= array('ru', 'en');	
	$CONF['defaultoutline']	= 'outline.html';
	$CONF['outlines']		= array('outline.html');
	
	//================= DEFINES ===========================
	
	
	define('DEBUG', 			true);
	
	define('SITETHUMB_WIDTH', 	150);
	define('SITETHUMB_HEIGHT', 	150);
	define('ADMINTHUMB_WIDTH', 	100);
	define('ADMINTHUMB_HEIGHT',	100);	
	
	define('TMP', 				$CONF['location'] . '/tmp/');
	define('GALLERY', 			$CONF['location'] . '/gallery/');
	define('APP_STD', 			$CONF['location'] . '/apps/standard/');
	define('APP_SITE', 			$CONF['location'] . '/apps/site/');	
	
	define('SITE_MOD_DIR', 		APP_SITE . '/modules/');
	define('SITE_TPL_DIR', 		APP_SITE . '/tpl/');	
	define('ADMIN_TPL_DIR', 	APP_STD . '/tpl/adm');
	
	
	//=============== BRING UP CLASSES AND ENGINES =+======
	
	require_once(APP_STD . '/includes/main.inc.php');
	
	mysql_set_charset('utf8'); 
	
	//=============== SITE VARS ===========================
	
