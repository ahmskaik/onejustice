<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->json('translations');
            $table->string('iso_code')->index();
            $table->string('language_code');
            $table->string('locale');
            $table->string('flag')->nullable();
            $table->boolean('is_rtl')->default(false);
            $table->smallInteger('sort_order');
            $table->boolean('is_active');

            $table->unsignedBigInteger('created_by');

            $table->foreign('created_by')->references('id')->on('system_users');


            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
