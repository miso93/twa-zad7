<?php

use Classes\ViewData;

require_once "function.php" ?>
<?php header('Content-type: text/html; charset=utf-8');

$router = new AltoRouter();

// map homepage
$router->map( 'GET', '/', function() {
    ViewData::put('page_id', 1);
    \Classes\View::get('page1');
});

$router->map( 'GET', '/page/[i:id]/[a:code]?', function($id, $code = null) {
    ViewData::put('page_id', $id);
    if($code != null){
        \Classes\ViewData::put('code', $code);
    }
    \Classes\View::get('page'.$id);
});

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