<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile_country_id')->nullable()->comment('refer to the calling code');
            $table->string('mobile')->nullable();
            $table->string('title')->nullable();
            $table->text('message');
            $table->string('ip')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_systemName')->nullable();
            $table->string('device_systemVersion')->nullable();
            $table->timestamp('seen_at')->nullable();

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
        Schema::dropIfExists('inquiries');
    }
}
