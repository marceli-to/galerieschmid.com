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
    Schema::create('newsletters', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->tinyInteger('active')->default(0);
      $table->tinyInteger('show_in_archive')->default(0);
      $table->foreignId('language_id')->constrained('newsletter_languages');
      $table->foreignId('user_id')->constrained('users');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('newsletters');
  }
};
