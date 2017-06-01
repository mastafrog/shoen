<?php
require_once 'app/database.php';

class Model {
	
	private $db;
	
	public function __construct() {
		self::$db = new Database();
	}
	
	public static function all() {
		$list = [];
		$db = self::$db->getConnection();
		print_r("<br>");
		echo var_dump($db);
		$req = $db->query('SELECT * FROM tours');
		
		// we create a list of Post objects from the database results
		foreach($req->fetchAll() as $post) {
			$list[] = new Post($post['id'], $post['title'], $post['short_desc']);
		}
		return $list;
	}
}



/**
 *  https://github.com/panique/php-login-minimal
 *  
app.zeplin.io


http://requiremind.com/a-most-simple-php-mvc-beginners-tutorial/
https://www.php-einfach.de/experte/objektorientierte-programmierung-oop/php-design-patterns/model-view-controller-in-php/
*/
