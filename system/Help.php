<?php
/*class Help {
	public function redirect_to($url) {
		header ('location: /'.$GLOBALS['config']['basefolder'].'/'.$url);
		exit;
	}
	public function clean_input($input) {
		foreach ($input as $key => $value) {
			$input[$key] = mysql_real_escape_string($value);
		}
		return $input;
	}
	public function site_url() {
		return '/'.(!empty($GLOBALS['config']['basefolder']))?$GLOBALS['config']['basefolder'].'/':'';
	}
}
*/








class Help {
	public function redirect_to($url) {
		header ('location: /'.$GLOBALS['config']['basefolder'].'/unilorinapartment/'.$url);
		exit;
	}
	public function clean_input($input) {
		foreach ($input as $key => $value) {
			//$input[$key] = mysql_real_escape_string($value);
			$input[$key] = $value;
		}
		return $input;
	}
	public function site_url() {
		return '/'.((!empty($GLOBALS['config']['basefolder']))? $GLOBALS['config']['basefolder'].'/unilorinapartment/' : '');
	}
}

?>