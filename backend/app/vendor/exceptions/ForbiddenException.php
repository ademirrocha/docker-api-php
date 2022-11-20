<?php

namespace app\vendor\exceptions;

class ForbiddenException extends \Exception
{

    protected $code = 403;
    protected $message = "Você não possui permissão para executar essa ação";

}