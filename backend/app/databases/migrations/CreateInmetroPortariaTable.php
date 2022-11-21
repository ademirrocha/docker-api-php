<?php

namespace app\databases\migrations;

use app\vendor\databases\migrations\Migrate;
use app\vendor\databases\Table;

class CreateInmetroPortariaTable extends Migrate
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = new Table('inmetr_portarias');
        $table->create([
            'DocumentoLegal' => ['string'],
            'DataPublicacaoDOU' => ['string'],
            'IDEscopo' => ['int'],
            'DataVigenciaFabricacao' => ['string'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = new Table('inmetr_portarias');
        $table->dropIfExists();
    }


}