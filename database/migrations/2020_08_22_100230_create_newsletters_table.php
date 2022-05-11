<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->date('date');
            $table->string('cover_image')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_active')->nullable();
            $table->unsignedInteger('language_id');
            $table->unsignedBigInteger('created_by');

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
        Schema::dropIfExists('posts');
    }
}
