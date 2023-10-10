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
    Schema::create('attributes', function (Blueprint $table) {
      $table->id();
      $table->text('description_de');
      $table->text('description_en')->nullable();
      $table->foreignId('attribute_group_id')->nullable()->constrained();
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
    Schema::dropIfExists('attributes');
  }
};
