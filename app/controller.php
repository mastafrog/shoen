<?php
require 'view.php';

class Controller {
	
	public $m;
	
	function __construct() {
		$this->view = new View();
		echo "constructed";
	}
	
	public function load_model($name) {
		echo "<br><b>loading model</b><br>";
		$path = 'app/models/'.$name.'.php';
		if (file_exists($path)) {
			require $path;
			$model_name = implode('_', array_map('ucfirst', explode('_', $name)));
			$this->m = new $model_name();
		}
	/*	echo "<br>";
		$bla = $this->m->find_one(1);
		echo $bla['title'];*/
	}
}