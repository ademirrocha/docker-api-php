<?php

namespace app\databases\migrations;

use app\vendor\databases\migrations\Migrate;
use app\vendor\databases\Table;

class CreateInmetroDadosPacsTable extends Migrate
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = new Table('inmetr_dados_pacs');
        $table->create([
            'ProdutosServicos' => ['string'],
            'MecanismoAvaliacaoConformidade' => ['string'],
            'Modelos' => ['string'],
            'MarcaModeloouFamilia' => ['string'],
            'risco' => ['string'],
            'IPEM' => ['string'],
            'Periodicidade' => ['string'],
            'Portarias' => ['string'],
            'Registro' => ['string'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = new Table('inmetr_dados_pacs');
        $table->dropIfExists();
    }


}