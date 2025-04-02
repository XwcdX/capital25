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
        Schema::create('commodity_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('team_id');
            $table->uuid('commodity_id');
            $table->uuid('phase_id');
            $table->integer('quantity');
            $table->decimal('return_rate', 5, 4);
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('commodity_id')->references('id')->on('commodities')->onDelete('cascade');
            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodity_histories');
    }
};
