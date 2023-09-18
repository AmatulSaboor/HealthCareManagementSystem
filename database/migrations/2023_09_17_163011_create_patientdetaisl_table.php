<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientdetaislTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Patient_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('image_link')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('city')->nullable();
            $table->string('allergies')->nullable();
            $table->boolean('is_BP_patient')->default(false);
            $table->boolean('is_heart_patient')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Patient_details');
    }
}
