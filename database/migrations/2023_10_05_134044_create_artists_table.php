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
    Schema::create('artists', function (Blueprint $table) {
      $table->id();
      $table->string('salutation', 100)->nullable();
      $table->string('artist_name');
      $table->string('firstname')->nullable();
      $table->string('lastname');
      $table->string('website')->nullable();
      $table->text('biography_de')->nullable();
      $table->text('biography_en')->nullable();
      $table->text('bank_account')->nullable();
      $table->string('mobile')->nullable();
      $table->string('email')->nullable();
      $table->tinyInteger('newsletter_subscriber')->default(0);
      $table->tinyInteger('publish')->default(0);
      $table->tinyInteger('position')->default(-1);
      $table->foreignId('artist_type_id')->nullable()->constrained();
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
    Schema::dropIfExists('artists');
  }
};
