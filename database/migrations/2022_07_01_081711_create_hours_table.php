<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('monday_start')->default('09:00');
            $table->string('monday_end')->default('17:00');
            $table->string('tuesday_start')->default('09:00');
            $table->string('tuesday_end')->default('17:00');
            $table->string('wednesday_start')->default('09:00');
            $table->string('wednesday_end')->default('17:00');
            $table->string('thursday_start')->default('09:00');
            $table->string('thursday_end')->default('17:00');
            $table->string('friday_start')->default('09:00');
            $table->string('friday_end')->default('17:00');
            $table->string('saturday_start')->default('09:00');
            $table->string('saturday_end')->default('17:00');
            $table->string('sunday_start')->default('09:00');
            $table->string('sunday_end')->default('17:00');
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
        Schema::dropIfExists('hours');
    }
};
