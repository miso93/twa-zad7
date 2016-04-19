<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 08.03.2016
 * Time: 22:07
 */
if (session_id() == "") {
    session_start();
}

require_once "config.php";
require __DIR__ . '/vendor/autoload.php';

dibi::connect([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'username' => Config::get('mysql.user'),
    'password' => Config::get('mysql.pass'),
    'database' => Config::get('mysql.db_name'),
    'charset'  => Config::get('mysql.charset'),
]);

function dd($arr)
{

    ?>
    <pre>
    <?php
    print_r($arr);
    ?>
    </pre>
    <?php
    die();
}

function route($route){
    return Config::get('app.base_url').'/'.$route;
}

function getRealIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
