<?php 
require_once 'app/model.php';

class Tour_Model extends Model {
	
	public $connection;
	
	function __construct() {
		parent::__construct();
	//	$this->__construct();
		$this->connection = self::$db->getConnection();
	}
	
	function init() {
    //    return $this->db->getInstance();
	}
	
	function find_all() {
		$list = [];
		$req = $db->query('SELECT {id} FROM tours');
		
		foreach($req->fetchAll() as $post) {
			$list[] = new Post($post['id'], $post['title'], $post['short_desc']);
		}
		return $list;
	}
	
	
	function find_one($id) {
		
	/*	echo "starting findone <br>";
		$db = self::$db->getConnection();
		$req = $db->query('SELECT {id} FROM tours');
		echo "<br>". var_dump($req)."<br>";
		$one = $req->fetchAll();*/
		
		$query = $this->connection->prepare("SELECT * FROM tours WHERE id = ?");
        $query->execute(array($id));
		
		if (!$row = $query->fetch(\PDO::FETCH_ASSOC)) {
			return false;
		}
		
		$result = $row;
		return $result;
	}
}
