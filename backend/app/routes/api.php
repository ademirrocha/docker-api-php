<?php

use app\vendor\routes\api\Route;

/**
 * -----------------------------------------------
 * PHP Route Things
 * -----------------------------------------------
 */

Route::post('/users/create', function(){
    call_user_func("app\http\controllers\UserController::create");
});

Route::get('/users', function(){
    call_user_func("app\http\controllers\UserController::index");
});

Route::get('/inmetro/pacs', function(){
    call_user_func("app\http\controllers\PacsInmetroController::pacs");
});

Route::get('/inmetro/dados-pac', function(){
    call_user_func("app\http\controllers\PacsInmetroController::dados_pac");
});

