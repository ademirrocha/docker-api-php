<?php

use app\http\controllers\UserController;
use app\vendor\routes\api\Route;

/**
 * -----------------------------------------------
 * PHP Route Things
 * -----------------------------------------------
 */

// route for www.example.com/join
Route::post('/user/create', function(){
    UserController::create();
});

// route for www.example.com/join
Route::get('/users', function(){
    UserController::index();
});

