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
            $table->id();
            $table->uuid('rally_id');
            $table->uuid('team_id');
            $table->uuid('phase_id');
            $table->timestamp('qr_expired_at');
            $table->text('qr');
            $table->timestamp('scanned_at')->nullable();
            $table->timestamps();

            $table->foreign('rally_id')->references('id')->on('rallies')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('cascade');
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
