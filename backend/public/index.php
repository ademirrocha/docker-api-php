<?php

// set autoload
spl_autoload_register(function ($class) {
    require_once(str_replace('\\', '/', '../' . $class . '.php'));
});


include "../app/routes/routes.php";