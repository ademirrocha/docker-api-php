<?php

namespace app\vendor\http;

class Response
{

    static public function json($data, $status = 200)
    {
        http_response_code($status);
       return print json_encode(['data' => $data]);
    }
}