<?php

namespace app\models\inmetro;

use app\vendor\models\Model;

class DadosPacs extends Model
{

    protected string $tableName = 'inmetr_dados_pacs';

    public function __construct()
    {
        parent::__construct($this->tableName);
    }

    public function get()
    {
        $portarias = parent::get();
        $result = [];
        foreach ($portarias as $portaria){
            $ports = [];
            foreach (explode('|', $portaria['Portarias']) as $port){
                $dado = new Portarias();
                $dado->where('DocumentoLegal', $port);
                $result = current($dado->get());
                $result['DataVigenciaFabricacao'] = json_decode($result['DataVigenciaFabricacao']);
                $ports[] = $result;
            }
            $portaria['Portarias'] = $ports;
            $result[] = $portaria;
        }
        return $result;
    }
}