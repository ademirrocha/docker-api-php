<?php

use app\vendor\http\controllers\Controller;
use app\vendor\routes\api\Route;

/**
 * -----------------------------------------------
 * PHP Route Things
 * -----------------------------------------------
 */

Route::post('/users/create', function(){
    Controller::call('UserController', 'create');
});

Route::get('/users', function(){
    Controller::call('UserController', 'index');
});

Route::get('/inmetro/pacs', function(){
    Controller::call('UserController', 'pacs');
    call_user_func("app\http\controllers\PacsInmetroController::pacs");
});

Route::get('/inmetro/dados-pac', function(){
    Controller::call('PacsInmetroController', 'dados_pac');
});

