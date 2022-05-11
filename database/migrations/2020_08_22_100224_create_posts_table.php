<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('summary');
            $table->longText('body');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedInteger('language_id');
            $table->unsignedBigInteger('type_id');
            $table->boolean('is_featured');
            $table->dateTime('date');
            $table->string('cover_image');
            $table->bigInteger('views')->default(0)->nullable();
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('created_by');


            $table->foreign('status_id')->references('id')->on('system_lookup');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('type_id')->references('id')->on('system_lookup');

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
        Schema::dropIfExists('posts');
    }
}
