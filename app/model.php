<?php
require_once 'app/database.php';

class Model {
	
	private $db;
	
	public function __construct() {
		$this->db = new Database();
	}
	
	public static function all() {
		$list = [];
		$db = $this->db->getConnection();
		$req = $db->query('SELECT * FROM tours');
		
		// we create a list of Post objects from the database results
		foreach($req->fetchAll() as $post) {
			$list[] = new Post($post['id'], $post['title'], $post['short_desc']);
		}
		return $list;
	}
}

/**

*/