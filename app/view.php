<?php
class View {
	
	public $data;

	public function render($name, $data) {

		extract($data);
		
		require 'app/views/header.php';
		require 'app/views/' . $layout . '.php';
		require 'app/views/footer.php';
	}
}