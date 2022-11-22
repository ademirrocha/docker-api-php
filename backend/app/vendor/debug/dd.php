<?php

function dd($x, $die = false)
{
    echo '<pre>';

    array_map(function($x) {var_dump($x);}, func_get_args());

    if($die){
        echo '</pre>';
        die;
    }
    return '';
}