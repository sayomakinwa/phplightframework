<?php

class AppDefault extends Controller{

	function index () {
		$this->view->render('home');

	}

	function invalidURL() {

		$GLOBALS['page_title'] = 'Bad Request';

		$this->data['breadcrumb'] = 'Go back to the <li><a href="/'.((!empty($this->basefolder))? $this->basefolder.'/' : '').'">Homepage</a></li>';

		$this->view->render('invalidURL', $this->data);

	}

}

?>