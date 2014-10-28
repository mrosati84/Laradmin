<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function ($t) {
            $t->increments('id');
            $t->string('number');
            $t->integer('user_id')
                ->nullable()
                ->default(null)
                ->unsigned();
            $t->timestamps();

            $t->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('phones');
    }
}
