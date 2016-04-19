<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 13.03.2016
 * Time: 19:12
 */

namespace Classes;

class ViewData
{

    private static $view_data = [];

    public static function put($key, $data)
    {
        self::$view_data[$key] = $data;
    }

    public static function getAll()
    {
        return self::$view_data;
    }

    public static function getAllJSON()
    {
        return json_encode(self::$view_data);
    }

    public static function get($key)
    {
        if (isset(self::$view_data[$key])) {
            return self::$view_data[$key];
        }

        return null;
    }
}
