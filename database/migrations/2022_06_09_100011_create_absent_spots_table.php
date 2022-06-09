<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsentSpotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absent_spots', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('name_spot')->default('Office');
            $table->string('latitude');
            $table->string('longitude');
            $table->text('address');
            $table->string('status');

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
        Schema::dropIfExists('absent_spots');
    }
}
