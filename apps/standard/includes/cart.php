<?php

	session_start();
	
	if (!isset($_SESSION['shop'])){ //init cart
		$_SESSION['shop']=array('items'=>array(), 'delivery'=>'array');
	}

?>