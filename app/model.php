<?php
require_once 'app/database.php';

class Model {
	
	static $db;
	
	public function __construct() {
		self::$db = new Database();
	}
}



/**
 *  https://github.com/panique/php-login-minimal
 *  
app.zeplin.io
mastafrog-zepyxfrog123


http://requiremind.com/a-most-simple-php-mvc-beginners-tutorial/
https://www.php-einfach.de/experte/objektorientierte-programmierung-oop/php-design-patterns/model-view-controller-in-php/
*/
