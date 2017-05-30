<?php
require 'view.php';

class Controller {
	
	function __construct() {
		$this->view = new View();
		echo "constructed";
	}
	
	public function loadModel($name) {
		
		$path = 'app/models/'.$name.'.php';
		if (file_exists($path)) {
			require $path;
		//	$model_name = ucfirst($name);
			$this->model = new $model_name();
		}
	}
}