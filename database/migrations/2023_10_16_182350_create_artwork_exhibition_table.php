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
      Schema::create('artwork_exhibition', function (Blueprint $table) {
        $table->id();
        $table->integer('position')->default(0);
        $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
        $table->foreignId('exhibition_id')->constrained()->onDelete('cascade');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};