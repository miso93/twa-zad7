<?php

namespace Classes;

use Config;

class View {

    public static function get($view)
    {
        $file = Config::get('app.dir_view').'/'.str_replace(".","/",$view). '.php';

        if(file_exists($file)){
            include $file;
        }
    }

}