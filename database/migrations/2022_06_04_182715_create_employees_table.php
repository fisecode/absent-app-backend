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
            $table->unsignedBigInteger('user_id');
            $table->string('name', 100);
            $table->string('email');
            $table->string('password');
            $table->date('dob')->nullable();
            $table->string('gender', 20);
            $table->string('phone', 50)->nullable();
            $table->text('address');
            $table->string('employee_id');
            $table->date('doj', 50)->nullable();
            $table->string('division', 50)->nullable();
            $table->string('work_from', 20)->nullable();

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
