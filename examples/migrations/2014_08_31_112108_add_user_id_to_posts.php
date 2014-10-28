<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function ($t) {
            $t->integer('user_id')
                ->nullable()
                ->default(null)
                ->unsigned();

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
        Schema::table('posts', function ($t) {
            $t->dropColumn('user_id');
        });
    }
}
