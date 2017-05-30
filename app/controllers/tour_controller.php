<?php
class Tour_Controller extends Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
	    echo "<br> tour controller</br>";
		$this->view->title = 'Welcome :D';
		$this->view->render('landingpage');
	}
}