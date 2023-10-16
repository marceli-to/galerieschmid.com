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
    Schema::create('exhibitions', function (Blueprint $table) {
      $table->id();
      $table->string('title_de');
      $table->string('title_en')->nullable();
      $table->string('subtitle_de')->nullable();
      $table->string('subtitle_en')->nullable();
      $table->text('summary_de')->nullable();
      $table->text('summary_en')->nullable();
      $table->text('text_de')->nullable();
      $table->text('text_en')->nullable();
      $table->string('keywords_de')->nullable();
      $table->string('keywords_en')->nullable();
      $table->date('date_start')->nullable();
      $table->date('date_end')->nullable();
      $table->date('date_show_from')->nullable();
      $table->date('date_show_to')->nullable();
      $table->tinyInteger('active')->default(0);
      $table->foreignId('user_id')->nullable()->constrained();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exhibitions');
  }
};
