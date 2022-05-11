<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_action', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('action_id');

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('action_id')->references('id')->on('actions');

            $table->primary(['role_id', 'action_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_action');
    }
}
