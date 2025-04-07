<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('phase_id');
            $table->string('name');
            $table->string('image');
            $table->text('description');
            $table->unsignedInteger('price');
            $table->decimal('return_rate', 5, 4);
            $table->timestamps();

            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('cascade');
        });
        DB::statement('ALTER TABLE commodities ADD CONSTRAINT check_return_rate CHECK (return_rate >= 0 AND return_rate <= 1)');
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodities');
    }
};
