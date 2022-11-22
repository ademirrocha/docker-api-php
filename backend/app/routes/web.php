<?php

use app\vendor\http\controllers\Controller;
use app\vendor\routes\Route;
use app\vendor\views\View;

/**
 * -----------------------------------------------
 * PHP Route Things
 * -----------------------------------------------
 */

//define your route. This is main page route. for example www.example.com
Route::get('/', function(){
    View::call();
});

Route::post('/login', function(){
    Controller::call('LoginController', 'login');
});

Route::post('/logout', function(){
    View::call('logout');
});

Route::get('/users/user', function(){
    View::call('user');
});

Route::resource('/notFound', function(){
    View::call('notFound');
});

