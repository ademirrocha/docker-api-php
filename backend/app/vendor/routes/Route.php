<?php

namespace app\vendor\routes;

/**
 * @author      JAdemir Rocha Ferreira <tiademir.rocga93@gmail.com>
 * @copyright   Copyright (C), 2022 Ademir Rocha Ferreira
 * @license     GNU General Public License 3 (http://www.gnu.org/licenses/)
 *              Refer to the LICENSE file distributed within the package.
 *
 * @link        http://jream.com
 *
 * @internal    Inspired by Klein @ https://github.com/chriso/klein.php
 */

class Route
{
    /**
    * @var array $_listUri List of URI's to match against
    */
    protected static $_listUri = array();


    protected static $error_method = false;

    /**
    * @var array $_listCall List of closures to call 
    */
    protected static $_listCall = array();

    /**
    * @var string $_trim Class-wide items to clean
    */
    protected static $_trim = '/\^$';

    /**
    * get - Adds a URI and Function to the two lists for Requests GET
    *
    * @param string $uri A path such as about/system
    * @param object $function An anonymous function
    */
    static public function get($uri, $function)
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::resource($uri, $function);
        } else if(rtrim($_SERVER['REQUEST_URI'], '/') === $uri) {
            self::$error_method = true;
            echo 'Error: Method Request GET Only';
        }

    }

    /**
     * post - Adds a URI and Function to the two lists  Requests POST
     *
     * @param string $uri A path such as about/system
     * @param object $function An anonymous function
     */
    static public function post($uri, $function)
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            self::resource($uri, $function);
        } else if(rtrim($_SERVER['REQUEST_URI'], '/') === $uri) {
            self::$error_method = true;
            echo 'Error: Method Request POST Only';
        }

    }

    /**
     * post - Adds a URI and Function to the two lists  Requests PUT
     *
     * @param string $uri A path such as about/system
     * @param object $function An anonymous function
     */
    static public function put($uri, $function)
    {
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            self::resource($uri, $function);
        } else if(rtrim($_SERVER['REQUEST_URI'], '/') === $uri) {
            self::$error_method = true;
            echo 'Error: Method Request POST Only';
        }

    }

    /**
     * post - Adds a URI and Function to the two lists  Requests DELETE
     *
     * @param string $uri A path such as about/system
     * @param object $function An anonymous function
     */
    static public function delete($uri, $function)
    {
        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            self::resource($uri, $function);
        } else if(rtrim($_SERVER['REQUEST_URI'], '/') === $uri) {
            self::$error_method = true;
            echo 'Error: Method Request DELETE Only';
        }

    }

    /**
     * resource - Adds a URI and Function to the two lists for all requests
     *
     * @param string $uri A path such as about/system
     * @param object $function An anonymous function
     */
    static public function resource($uri, $function)
    {
        $uri = rtrim(trim($uri, self::$_trim), '/');
        self::$_listUri[] = $uri;
        self::$_listCall[] = $function;
    }

    /**
    * submit - Looks for a match for the URI and runs the related function
    */
    static public function submit()
    {   
        $uri = isset($_SERVER['REQUEST_URI']) ? explode('?', $_SERVER['REQUEST_URI'])[0] : '/';
        //var_dump($_SERVER);

        $uri = rtrim(trim($uri, self::$_trim), '/');
        
        if(!self::$error_method && !in_array($uri, self::$_listUri)){
            $uri = 'notFound';
        }
        $replacementValues = array();
        
        /**
        * List through the stored URI's
        */
        foreach (self::$_listUri as $listKey => $listUri)
        {
            /**
            * See if there is a match
            */
            if (preg_match("#^$listUri$#", $uri))
            {
                /**
                * Replace the values
                */
                $realUri = explode('/', $uri);
                $fakeUri = explode('/', $listUri);

                /**
                * Gather the .+ values with the real values in the URI
                */
                foreach ($fakeUri as $key => $value) 
                {
                    if ($value == '.+') 
                    {
                        $replacementValues[] = $realUri[$key];
                    }
                }

                /**
                * Pass an array for arguments
                */
                call_user_func_array(self::$_listCall[$listKey], $replacementValues);
            }

        }

    }

}