<?php
require_once 'app/router.php';
//require_once 'app/controller.php';


/*https://github.com/liamjack/AuthPortal */
/* TODO - Namespaces
namespace Model; 
class Welcome extends \Model {
use \Model\Welcome;
class Controller_Welcome extends Controller {...
*/

// $a = new Auth();

$basepath = 'shoen';
echo "<pre>";

/*  Routen  */

$r = new router();
$r->set_basepath($GLOBALS["basepath"]);


$r->add('', function() {
	require_once 'app/controllers/tour_controller.php';
	$c = new Tour_Controller();
	$c->index();
});


$r->add('tour/(.*)', function($id) {
	require_once 'app/controllers/tour_controller.php';
	$c = new Tour_Controller();
	$c->view($id);
});


$r->add('admin/(.*)/edit', function($id) {
	require_once 'app/database.php';
	require_once 'app/auth.php';
	
	$db =	new \Database();
	$auth = new \Auth($db->getConnection());
		
	if (!$auth->is_logged()) {
		header("Location: ". $_SERVER['HTTP_HOST'] .'/'. $GLOBALS["basepath"]);
		die();
	}
});

$r->add('(.*)/(.*)/(.*)/(.*)', function($var1,$var2,$var3,$var4) {
	echo 'You have entered: '.$var1.' / '.$var2.' / '.$var3.' / '.$var4.'<br/>';
});

$r->add404(function($url) {
	header("HTTP/1.0 404 Not Found");
	echo '404 :-(<br/>';
    echo $url.' not found!';
});

$r->run();



/* TODO maybe slim style

$app = new \Slim\App();
$app->put('/books/{id}', function ($request, $response, $args) {
    // Update book identified by $args['id']
});

http://requiremind.com/a-most-simple-php-mvc-beginners-tutorial/
https://www.php-einfach.de/experte/objektorientierte-programmierung-oop/php-design-patterns/model-view-controller-in-php/


*/