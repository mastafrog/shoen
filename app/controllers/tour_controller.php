<?php
require_once 'app/model.php';
require_once 'app/database.php';


class Tour_Controller extends Controller {
	
	private $tours;
	private $db;
	
	function __construct() {
		parent::__construct();
		//TODO Implement Model	$this->tours = new Model();
		$this->db = new Database();
	}
	
	function index() {
		
	//	$sth = $this->tours->prepare("SELECT * FROM tours");
	//	$sth->execute();
	/* Fetch all of the remaining rows in the result set */
		
		echo "<br>";
		$list = [];
		$con = $this->db->getConnection();
		$req = $con->query('SELECT * FROM tours');
		
		// we create a list of Post objects from the database results
		foreach($req->fetchAll() as $post) {
			$list[] = array($post['id'], $post['title'], $post['short_desc']);
		}
		
		echo var_dump( $list );
		echo "<br>";

	    echo "<br> tour controller</br>";
		$this->view->title = 'Welcome :D';
		$this->view->render('landingpage');
	}
	
	function get_all() {
		
	}
}