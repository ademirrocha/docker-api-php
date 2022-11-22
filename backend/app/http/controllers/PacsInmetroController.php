<?php

namespace app\http\controllers;

use app\models\inmetro\DadosPacs;
use app\models\inmetro\Pacs;
use app\vendor\http\controllers\Controller;
use app\vendor\http\Response;

class PacsInmetroController extends Controller
{

    public function pacs(){
        $query = new Pacs();
        $all = $query->get();
        return Response::json($all);
    }

    public function dados_pac(){
        $query = new DadosPacs();
        $all = $query->with('Portarias')->get();
        return Response::json($all);
    }

}