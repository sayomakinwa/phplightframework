<?php
class Controller {
	public function __construct() {
		foreach ($GLOBALS['config'] as $key => $value) {
			$this->$key = $value;
		}
		include_once 'system/View.php';
		include_once 'system/Sessions.php';
		include_once 'system/Help.php';
		#include_once 'system/Model.php';

		$this->view = new View();
		$this->session = new Sessions();
		$this->help = new Help();

		$this->session->reduce_msg_validity();
		#$this->model = new Help();

		$this->data = (array)$this;
	}


	public function model($model, $var_name="") {
		include_once 'models/'.$model.'.php';

		if (empty($var_name)) {
			$model=strtolower($model);
			$this->$model = new $model();
		}
		else {
			$this->$var_name = new $model();
		}
		#return new $model($arg);
	}

	public function library($lib, $var_name="") {
		include_once 'libraries/'.$lib.'.php';

		if (empty($var_name)) {
			$lib=strtolower($lib);
			$this->$lib = new $lib();
		}
		else {
			$this->$var_name = new $lib();
		}
		#return new $model($arg);
	}
}
?>