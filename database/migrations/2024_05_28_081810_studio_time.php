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
        // Schema::create('studio_time', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('studio_id')->constrained()->onDelete('cascade');
        //     $table->date('date');
        //     $table->time('start_time');
        //     $table->time('end_time');
        //     $table->string('price');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('studio_time');
    }
};
