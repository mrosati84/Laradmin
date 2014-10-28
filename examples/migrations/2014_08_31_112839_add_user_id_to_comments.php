<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function ($t) {
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
        Schema::table('comments', function ($t) {
            $t->dropColumn('user_id');
        });
    }
}
