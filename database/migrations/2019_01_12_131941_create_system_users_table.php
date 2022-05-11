<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('system_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('user_name')->unique()->index();
            $table->string('email')->unique()->index();
            $table->string('password');
            $table->dateTime('dob')->nullable();
            $table->string('mobile')->nullable();
            $table->timestamp('last_loginDate')->nullable();
            $table->string('last_IPAddress')->nullable();
            $table->string('avatar')->nullable();
            $table->string('api_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->text('fcm_token')->nullable();


            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('created_by')->references('id')->on('system_users');
            $table->foreign('status')->references('id')->on('system_lookup')->onDelete('cascade');

            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_users');
    }
}
