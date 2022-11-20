<?php

use app\http\controllers\LoginController;
use app\vendor\routes\Route;
use app\views\View;

/**
 * -----------------------------------------------
 * PHP Route Things
 * -----------------------------------------------
 */

//define your route. This is main page route. for example www.example.com
Route::get('/', function(){
   new View('myindex');
});


Route::post('/login', function(){
    LoginController::login();
});

Route::post('/logout', function(){
    new View('logout');
});

Route::get('/users/user', function(){
    new View('user');
});

Route::resource('/notFound', function(){
    new View('notFound');
});

//method for execution routes
//Route::submit();
