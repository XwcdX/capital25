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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id');
            $table->enum('transaction_type', ['coin', 'green_point']);
            $table->enum('action', ['credit', 'debit']);
            $table->decimal('amount', 15, 2);

            $table->uuid('commodity_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->json('meta')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('commodity_id')->references('id')->on('commodities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
