<?php

namespace app\http\controllers;

use app\models\inmetro\DadosPacs;
use app\models\inmetro\Pacs;
use app\vendor\http\Response;

class PacsInmetroController extends BaseController
{

    public static function pacs(){
        $query = new Pacs();
        $all = $query->get();
        return Response::json($all);
    }

    public static function dados_pac(){
        $query = new DadosPacs();
        $all = $query->get();
        return Response::json($all);
    }

}