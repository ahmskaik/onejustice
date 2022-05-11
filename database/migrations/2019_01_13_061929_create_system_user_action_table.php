<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemUserActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_user_action', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('action_id');

            $table->foreign('user_id')->references('id')->on('system_users');
            $table->foreign('action_id')->references('id')->on('actions');

            $table->primary(['user_id', 'action_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_user_action');
    }
}
