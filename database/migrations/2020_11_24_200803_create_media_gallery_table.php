<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_gallery', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->string('link')->nullable();
            $table->string('file_name')->nullable();
            $table->string('type')->index()->default('image');
            $table->smallInteger('sort_order')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->unsignedInteger('language_id')->nullable();

            $table->foreign('language_id')->references('id')->on('languages');
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
        Schema::dropIfExists('media_gallery');
    }
}
