<?php

namespace app\vendor\http;

class Response
{

    static public function json($data, $status = 200)
    {
        http_response_code($status);
       return print json_encode(['data' => $data]);
    }

    static public function error($status = 400, $message = 'Houve um erro ao executar essa acão')
    {
        http_response_code($status);
        return print json_encode(['message' => $message]);
    }
}