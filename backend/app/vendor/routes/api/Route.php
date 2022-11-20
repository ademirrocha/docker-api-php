<?php

namespace app\vendor\routes\api;

use app\vendor\routes\Route as BaseRoute;

/**
 * @author      Ademir Rocha Ferreira <tiademir.rocga93@gmail.com>
 * @copyright   Copyright (C), 2022 Ademir Rocha Ferreira
 * @license     GNU General Public License 3 (http://www.gnu.org/licenses/)
 *              Refer to the LICENSE file distributed within the package.
 *
 * @link        http://jream.com
 *
 * @internal    Inspired by Klein @ https://github.com/chriso/klein.php
 */

class Route extends BaseRoute
{

    /**
    * get - Adds a URI and Function to the two lists for Requests GET
    *
    * @param string $uri A path such as about/system
    * @param object $function An anonymous function
    */
    static public function get($uri, $function)
    {
        parent::get('/api' . $uri, $function);
    }

    /**
     * post - Adds a URI and Function to the two lists  Requests POST
     *
     * @param string $uri A path such as about/system
     * @param object $function An anonymous function
     */
    static public function post($uri, $function)
    {
        parent::post('/api' . $uri, $function);
    }

    /**
     * post - Adds a URI and Function to the two lists  Requests PUT
     *
     * @param string $uri A path such as about/system
     * @param object $function An anonymous function
     */
    static public function put($uri, $function)
    {
        parent::put('/api' . $uri, $function);
    }

    /**
     * post - Adds a URI and Function to the two lists  Requests DELETE
     *
     * @param string $uri A path such as about/system
     * @param object $function An anonymous function
     */
    static public function delete($uri, $function)
    {
        parent::delete('/api' . $uri, $function);
    }

}