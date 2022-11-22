<?php

namespace app\models\inmetro;

use app\vendor\models\Model;

/**
 * @property $Portarias
 */
class DadosPacs extends Model
{

    protected string $tableName = 'inmetr_dados_pacs';

    public function __construct()
    {
        parent::__construct($this->tableName);
    }
    
    protected array $fillable = [
        'ProdutosServicos',
        'MecanismoAvaliacaoConformidade',
        'Modelos',
        'MarcaModeloouFamilia',
        'risco',
        'IPEM',
        'Periodicidade',
        'Portarias',
        'Registro'
    ];

    public function Portarias($args): array
    {
        $ports = [];
        foreach (explode('|', $args->Portarias) as $port) {
            $portaria = new Portarias();
            $portaria->where('DocumentoLegal', $port);
            $current = $portaria->get();
            if (count($current)) {
                $current = current($current);
                $current->DataVigenciaFabricacao = json_decode($current->DataVigenciaFabricacao);
                $ports[] = $current;
            }
        }
        return $ports;
    }
}