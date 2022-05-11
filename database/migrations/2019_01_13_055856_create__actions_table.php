<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon')->nullable();
            $table->json('name');
            $table->string('group_name')->nullable();
            $table->json('menu_group_name')->nullable();
            $table->boolean('is_menuItem')->default(false);
            $table->boolean('is_active')->default(true);
            $table->smallInteger('menu_order');
            $table->integer('parent_action_id')->nullable();
            $table->integer('parent_action_id_menu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
