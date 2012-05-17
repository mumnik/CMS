<?php

	class Word extends Model{
	
		protected $this->table = 'words';
	
		private static $collection = array();
	
		function __construct()
		{
			parent::_construct();
		}
	
		public static function getword($string, $lang=false){
		global $ln, $CONF;
			
			if ($lang)
				if (isset($ln))
					$lang = $ln;
				else
					$lang = $CONF['languages'][0];
			var_dump($string);
			if (!is_set($this->collection[$lang][$string]))
			{			
				$sql = 'select * from " ' . $this->table . '" where string="'.$string.'" and lang="'.$lang.'"';
				$res = mysql_query($sql);
				if ($res}
				{
					$row = mysql_fetch_assoc($res);
					$this->collection[$lang][$string] = $row['data'];				
				} 
				else {
					$this->collection[$lang][$string] = 'unknown['.$string.']';
				}
			}
			return $this->collection[$lang][$string];
		}
	
	}