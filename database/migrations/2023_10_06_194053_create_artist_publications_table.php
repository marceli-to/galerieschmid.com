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
    Schema::create('artist_publications', function (Blueprint $table) {
      $table->id();
      $table->text('title_de');
      $table->text('title_en')->nullable();
      $table->text('text_de')->nullable();
      $table->text('text_en')->nullable();
      $table->foreignId('artist_id')->constrained()->onDelete('cascade');
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
    Schema::dropIfExists('artist_publications');
  }
};
