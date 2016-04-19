<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 08.03.2016
 * Time: 21:52
 */

define("ROOT", __DIR__ . "/");

ini_set('display_errors', 'On');
error_reporting(E_ALL);

class Config
{

    private static $config = [
        'mysql' => [
            'db_name' => 'twa-zad7',
            'user'    => 'twa-zad7',
            'pass'    => '2x8mDFTCzDNeDs2K',
            'charset' => 'utf8',
        ],
        'app'   => [
            'base_url' => 'http://twa-zad7',
            'dir_view' => 'views',
            'base_app' => ''
        ],
        'menu' => [
            'items' => [
                [
                    'title' => 'Page 1',
                    'route' => 'page/1'
                ],
                [
                    'title' => 'Page 2',
                    'route' => 'page/2'
                ],
                [
                    'title' => 'Page 3',
                    'route' => 'page/3'
                ]
            ]
        ]
    ];

    public static function get($key, $default = null)
    {
        list($first, $second) = explode('.', $key);

        if (isset(self::$config[$first][$second])) {
            return self::$config[$first][$second];
        }

        return $default;
    }
}