<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function ($t) {
            $t->increments('id');
            $t->integer('post_id')
                ->nullable()
                ->default(null)
                ->unsigned();
            $t->integer('tag_id')
                ->nullable()
                ->default(null)
                ->unsigned();
            $t->timestamps();

            $t->index('post_id');
            $t->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_tag');
    }
}
