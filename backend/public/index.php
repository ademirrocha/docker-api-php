<?php

// set autoload
spl_autoload_register(function ($class) {
    require_once(str_replace('\\', '/', '../' . $class . '.php'));
});

use app\vendor\routes\Route;
use app\vendor\routes\api\Route as RouteApi;

function startApp($useApi){

    include "../app/routes/web.php";

    //method for execution routes
    if($useApi){
        include "../app/routes/api.php";
        RouteApi::submit();
    } else {
        Route::submit();
    }
}

// For use api routes send start with true
startApp(true);


