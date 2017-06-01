<?php
require_once 'app/controller.php';

class Tour_Controller extends Controller {
	
	public $m;
	
	function __construct() {
		// Davor!
		parent::load_model('tour_model');
		// Start
		parent::__construct();
	}
	
	function index() {
	    echo "<br>tour controller</br>";
		$this->view->title = 'Welcome :D';
		$this->view->render('landingpage');
	}
	
	function view($id) {
		$data = $this->m->find_one($id) ;
		$this->view->title = $data['title'];
		$this->view->content = $data;
		$this->view->render('view_tour');
	}
}