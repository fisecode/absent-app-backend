<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->date('dob')->nullable();
            $table->string('gender');
            $table->string('phone')->nullable();
            $table->text('address');
            $table->string('employee_id');
            $table->date('doj')->nullable();
            $table->string('division')->nullable();
            $table->string('work_from')->nullable();

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
        Schema::dropIfExists('employees');
    }
}
