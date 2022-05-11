<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('body');
            $table->boolean('is_active');
            $table->boolean('is_featured');
            $table->dateTime('date');
            $table->string('link')->nullable();
            $table->unsignedBigInteger('type_id');
            $table->string('cover_image');
            $table->bigInteger('views')->default(0)->nullable();
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('created_by');

            $table->foreign('created_by')->references('id')->on('system_users');
            $table->foreign('type_id')->references('id')->on('system_lookup');

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
        Schema::dropIfExists('posts');
    }
}
