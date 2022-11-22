<?php

namespace app\databases\migrations;

use app\vendor\databases\migrations\Migrate;
use app\vendor\databases\Table;

class CreateInmetroPacsTable extends Migrate
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = new Table('inmetr_pacs');
        $table->create([
            'Codigo' => ['int'],
            'Nome' => ['string'],
            'Risco' => ['int'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = new Table('inmetr_pacs');
        $table->dropIfExists();
    }


}