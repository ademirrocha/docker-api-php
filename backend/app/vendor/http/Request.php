<?php

namespace app\vendor\http;

class Request
{

    protected $query_params;
    protected $body_params;

    public function __construct()
    {
        //Get parameters from body
        $request_body = file_get_contents('php://input');
        $this->body_params = json_decode($request_body);

        //Get parameters from query
        $url_components = parse_url($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        parse_str($url_components['query'], $this->query_params);
    }

    public function all(){
        return (object) array_merge($this->query_params, (array) $this->body_params);
    }

}