<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->string('number');
            $table->string('section')->nullable();
            $table->integer('year');
            $table->integer('files')->default(0);
            $table->json('last_analysis');
            $table->text('email_template');
            $table->json('students_notified');
            $table->unsignedBigInteger('owner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('classrooms');
    }
}
