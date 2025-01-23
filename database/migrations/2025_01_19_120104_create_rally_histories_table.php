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
        Schema::create('rally_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rally_id');
            $table->uuid('team_id');
            $table->timestamp('qr_expired_at');
            $table->timestamp('scanned_at')->nullable();
            $table->smallInteger('rank')->nullable()->comment('1: rank 1, 2: rank 2, 3: rank 3');
            $table->unsignedInteger('point')->nullable();
            $table->timestamps();

            $table->foreign('rally_id')->references('id')->on('rallies')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unique(['rally_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rally_histories');
    }
};
