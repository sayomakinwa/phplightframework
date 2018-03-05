<?php
class View {
	public function render($file, $data) {
		include_once 'views/'.$file.'.php';
		exit;
	}
}
?>