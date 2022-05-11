<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_route', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('action_id');
            $table->string('route_name');
            $table->boolean('is_logging')->nullable()->default(false);
            $table->boolean('is_LoggingDetails')->nullable()->default(false);
            $table->boolean('can_Logging')->nullable()->default(false);

            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_route');
    }
}
