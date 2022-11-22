<?php

namespace app\vendor\views;

class View
{

    public static function call($file = 'index', $params = null){
        $patch = explode('/app/vendor', __DIR__);
        include($patch[0]. '/' . VIEWS_PATH . '/' . $file . '.php');
    }

}