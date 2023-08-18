<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('employee_username');
            $table->string('game_name');
            $table->decimal('amount', 10, 2);
            $table->date('date');

            $table->foreign('employee_username')->references('username')->on('employees');
            $table->foreign('game_name')->references('name')->on('games');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
