<?php

use app\vendor\Route;
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


// route for www.example.com/join
Route::get('/join', function(){
    new View('join');
});


Route::get('/login', function(){
    new View('login');
   
});

Route::post('/forget', function(){
    new View('forget');
});

Route::post('/logout', function(){
    new View('logout');
});

Route::get('/users/user', function(){
    new View('user');
});

Route::get('/notFound', function(){
    new View('notFound');
});

//method for execution routes    
Route::submit();
