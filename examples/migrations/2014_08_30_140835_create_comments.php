<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function ($t) {
            $t->increments('id');
            $t->text('body');
            $t->integer('post_id')
                ->nullable()
                ->default(null)
                ->unsigned();
            $t->timestamps();

            $t->index('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
