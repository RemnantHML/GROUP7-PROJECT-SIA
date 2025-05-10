<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudySchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('study_schedules', function (Blueprint $table) {
            $table->id();  // Automatically creates an 'id' field
            $table->string('title');
            $table->string('description')->nullable();
            $table->dateTime('scheduled_at');
            $table->timestamps();  // created_at and updated_at fields
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_schedules');
    }
}
