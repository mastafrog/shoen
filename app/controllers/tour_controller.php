<?php
require_once 'app/controller.php';
//require_once 'app/models/tour_model.php';

class Tour_Controller extends Controller {
	
	public $m;
	
	function __construct() {
		// Davor!
		parent::load_model('tour_model');
		// Start
		parent::__construct();
	}
	
	function index() {
		
	//	$sth = $this->tours->prepare("SELECT * FROM tours");
	//	$sth->execute();

		/* Fetch all of the remaining rows in the result set */
		$result = $this->bla->all();
		print_r($result);
		
	    echo "<br> tour controller</br>";
		$this->view->title = 'Welcome :D';
		$this->view->render('landingpage');
	}
	
	function view($id) {
		
	//	$this->m = $this->load_model('tour_model');
		echo var_dump( $this->m->find_one($id) );
	}
}