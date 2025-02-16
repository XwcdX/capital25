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
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('school');
            $table->string('domicile');
            $table->string('proof_of_payment')->nullable();
            $table->timestamp('payment_uploaded_at')->nullable();
            $table->string('profile_image')->nullable();
            $table->unsignedInteger('coin')->default(1000000);
            $table->unsignedInteger('green_points')->default(0);
            $table->tinyInteger('valid')->default(0)->comment('0: Pending, 1: Validated, 2: Declined');
            $table->text('feedback')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
