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
      $table->text('address')->nullable();
      $table->text('address_additional')->nullable();
      $table->string('street')->nullable();
      $table->string('box', 100)->nullable();
      $table->string('zip', 100)->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('country')->nullable();
      $table->string('phone', 50)->nullable();
      $table->string('phone_business', 50)->nullable();
      $table->string('fax', 50)->nullable();
      $table->string('website')->nullable();
      $table->text('biography_de')->nullable();
      $table->text('biography_en')->nullable();
      $table->text('bank_account')->nullable();
      $table->string('mobile')->nullable();
      $table->string('email')->nullable();
      $table->tinyInteger('newsletter_subscriber')->default(0);
      $table->tinyInteger('publish')->default(0);
      $table->integer('position')->default(-1);
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
