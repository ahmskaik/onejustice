<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_lookup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_id')->index();
            $table->string('slug')->nullable()->index();
            $table->json('syslkp_data');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('system_user_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();


            $table->foreign('parent_id')->references('id')->on('system_lookup');
            //  $table->foreign('system_user_id')->references('id')->on('system_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_lookup');
    }
}
