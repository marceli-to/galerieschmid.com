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
    Schema::create('content_articles', function (Blueprint $table) {
      $table->id();
      $table->string('key', 50)->unique();
      $table->string('title_de');
      $table->string('title_en')->nullable();
      $table->text('text_de');
      $table->text('text_en')->nullable();
      $table->softDeletes();
      $table->foreignId('user_id')->constrained();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('content_articles');
  }
};
