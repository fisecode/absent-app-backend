<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absents', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('date');
            $table->string('status');
            $table->time('check_in');
            $table->time('check_out');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('absent_spot');
            $table->text('address');
            $table->text('photoPath');
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
        Schema::dropIfExists('absents');
    }
}
