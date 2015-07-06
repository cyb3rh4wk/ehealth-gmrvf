<?php

class Patient	{

	public function __construct()	{
		
	}
	/*
	String cleaning function
	*/
	public static function esc($str){
		
		if(ini_get('magic_quotes_gpc'))
			$str = stripslashes($str);
		
		return mysql_real_escape_string(strip_tags($str));
	}

}

?>