<?php

	class Model{		
	
		public static function getNextSystemId()
		{
			$sql = 'select systemid from systemid';
			$res = mysql_query($sql);
			$row = mysql_fetch_asoc($res);
			return $row['systemid'];
		}
		
		public static function shiftNextSystemId()
		{
			$sql = 'INSERT INTO  systemid (`systemid`)VALUES (NULL)';
			mysql_query($sql);
		}
		
		function __construct()
		{
			if ((isset($this->uses)) && (sizeof($this->uses)))
				foreach ($this->uses as $class => $data){										
					$this->$class = new $class($data);
				}
		}
	}