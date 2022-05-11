<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('icon')->nullable();
            $table->string('main_image')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('created_by');
            $table->boolean('is_active')->nullable();

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
        Schema::dropIfExists('categories');
    }
}
