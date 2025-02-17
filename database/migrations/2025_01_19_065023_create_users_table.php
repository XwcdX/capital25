<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->tinyInteger('gender')->comment('0: male, 1:female');
            $table->string('phone_number')->unique();
            $table->tinyInteger('position')->comment('0: Leader, 1: 1st Member, 2: 2nd Member, 3: 3rd Member');
            $table->string('line_id')->unique();
            $table->tinyInteger('consumption_type')->default(0)->comment('0: Normal, 1: Vege, 2: Vegan');
            $table->text('food_allergy')->nullable();
            $table->text('drug_allergy')->nullable();
            $table->text('medical_history')->nullable();
            $table->string('student_card')->unique();
            $table->string('twibbon')->unique();
            $table->uuid('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
