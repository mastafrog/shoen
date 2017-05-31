<?php 
require_once 'app/model.php';

class Tour_Model extends Model {
	
	function __construct() {
		parent::__construct();
	    //	$this->__construct();
	}
	
	function init() {
        return $this->db->getInstance();
	}
}
