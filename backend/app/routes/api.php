<?php

use app\vendor\routes\api\Route;

/**
 * -----------------------------------------------
 * PHP Route Things
 * -----------------------------------------------
 */

// route for www.example.com/join
Route::post('/users/create', function(){
    call_user_func("app\http\controllers\UserController::create");
});

// route for www.example.com/join
Route::get('/users', function(){
    call_user_func("app\http\controllers\UserController::index");
});

