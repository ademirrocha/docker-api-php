<?php

namespace app\databases\migrations;

use app\vendor\databases\migrations\Migrate;
use app\vendor\databases\Table;

class CreateUserTable extends Migrate
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = new Table('users');
        $table->create([
            'id' => ['uuid'],
            'nome' => ['string', 'size' => '33']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Table::dropIfExists('tags');
    }


}