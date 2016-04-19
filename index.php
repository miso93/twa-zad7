<?php

require_once "function.php" ?>
<?php header('Content-type: text/html; charset=utf-8');

$router = new AltoRouter();

// map homepage
$router->map( 'GET', '/', function() {
    \Classes\View::get('page1');
});

$router->map( 'GET', '/page/[i:id]', function($id) {
    \Classes\View::get('page'.$id);
});

// map user details page
//$router->map( 'GET', '/user/[i:id]/', function( $id ) {
//    require __DIR__ . '/views/user-details.php';
//});

$router->setBasePath(Config::get('app.base_app'));

// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
    // no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}