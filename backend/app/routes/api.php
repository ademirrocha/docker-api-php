<?php

use app\controllers\UserController;
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

