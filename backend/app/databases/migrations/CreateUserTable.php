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
            'id' => ['primaryKey'],
            'name' => ['string'],
            'email' => ['string', 'unique', 'size' => 60],
            'github' => ['string', 'size' => 60]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = new Table('users');
        $table->dropIfExists('users');
    }


}