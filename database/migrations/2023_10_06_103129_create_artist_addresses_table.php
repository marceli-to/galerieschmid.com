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
    Schema::create('artist_addresses', function (Blueprint $table) {
      $table->id();
      $table->text('address')->nullable();
      $table->text('address_additional')->nullable();
      $table->string('street')->nullable();
      $table->string('box', 100)->nullable();
      $table->string('zip', 100)->nullable();
      $table->string('city')->nullable();
      $table->string('country')->nullable();
      $table->string('phone', 50)->nullable();
      $table->string('phone_business', 50)->nullable();
      $table->string('fax', 50)->nullable();
      $table->foreignId('artist_id')->nullable()->constrained();
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
    Schema::dropIfExists('artist_addresses');
  }
};
