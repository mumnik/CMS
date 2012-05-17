<?php
//=====================================================
//	CMS Copyright
//	Copyright (c) 2008-2009 by CMS
//	ALL RIGHTS RESERVED
//=====================================================
?>
<?php

	define('CMS_VERSION','1.0beta');
	
	define('CMS_MODULE_DISABLED',	0);
	define('CMS_MODULE_ENABLED',	1);
	
	define('NEWS_PER_PAGE', 4);
	
	define('CMS_PF_DISABLED',	0);
	define('CMS_PF_ENABLED',	1);
	
	define('CMS_PF_TYPE_MODEL',		1);
	define('CMS_PF_TYPE_PHOTO',		2);
	
	define('CMS_PF_MODEL_WOMEN',	1);
	define('CMS_PF_MODEL_WOMEN_NEW',2);
	define('CMS_PF_MODEL_MEN',		3);
	define('CMS_PF_MODEL_MEN_NEW',	4);
	define('CMS_PF_MODEL_BECOME',	5);

	define('CMS_PF_MODEL_NOT_TOURNE',	0);
	define('CMS_PF_MODEL_TOURNE',		1);

	define('T_STR',			0);
	define('T_INT',			1);
	define('T_DBL',			2);
	define('T_ID',			3);
	define('T_PERIOD',		4);
	define('T_CLR',			5);
	define('T_INT_RANGE',	6);

	define('O_MAND',			0);
	define('O_OPT',				1);
	define('O_NO',				2);

	define('P_SYS',				1);
	define('P_UNSET_EMPTY',			2);
	define('P_ACT',				16);
	define('P_NZERO',			32);

	define('ZBX_EREG_MINUS_SYMB','-');
	
/* if magic quotes on then get rid of them */	
	if(get_magic_quotes_gpc()){
		function cms_stripslashes($value) {
			$value = is_array($value) ? array_map('CMS_stripslashes', $value) : stripslashes($value) ;
			return $value;
		}
		$_GET    = cms_stripslashes($_GET);
		$_POST	 = cms_stripslashes($_POST);
		$_COOKIE = cms_stripslashes($_COOKIE);
	}

/* init $_REQUEST */
	ini_set('variables_order', 'GP');
	$_REQUEST = $_POST + $_GET;
?>