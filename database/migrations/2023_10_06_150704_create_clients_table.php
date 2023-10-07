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
    Schema::create('clients', function (Blueprint $table) {
      $table->id();
      $table->string('salutation', 100)->nullable();
      $table->string('gallery');
      $table->string('alfa');
      $table->string('firstname')->nullable();
      $table->string('lastname');
      $table->string('website')->nullable();
      $table->string('mobile')->nullable();
      $table->string('email')->nullable();
      $table->string('language')->nullable();
      $table->text('letter_salutation')->nullable();
      $table->text('remarks')->nullable();
      $table->text('invitations')->nullable();
      $table->text('artists')->nullable();
      $table->tinyInteger('newsletter_subscriber')->default(0);
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
    Schema::dropIfExists('clients');
  }
};
