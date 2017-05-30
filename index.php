<?php
require_once 'app/router.php';
require_once 'app/controller.php';


echo "<pre>";
/*
 *  Routen
 */

$r = new router();

$r->set_basepath('shoen');

$r->add('', function() {
	echo 'Welcome :-)';
});

$r->add('test', function() {
	require_once 'app/controllers/tour_controller.php';
	$c = new Tour_Controller();
	$c->index();
});

$r->add('user/(.*)/edit', function($id) {
	echo 'Edit user with id '.$id.'<br/>';
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

*/