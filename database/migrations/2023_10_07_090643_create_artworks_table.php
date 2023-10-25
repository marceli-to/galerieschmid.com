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
    Schema::create('artworks', function (Blueprint $table) {
      $table->id();
      $table->string('image')->nullable();
      $table->string('inventory_number')->nullable();
      $table->string('artist_inventory_number')->nullable();
      $table->string('litho_number')->nullable();
      $table->string('description_de');
      $table->string('description_en')->nullable();
      $table->string('location')->nullable();
      $table->decimal('height', 9, 2)->nullable();
      $table->decimal('width', 9, 2)->nullable();
      $table->decimal('depth', 9, 2)->nullable();
      $table->decimal('diameter', 9, 2)->nullable();
      $table->year('year')->nullable();
      $table->date('date_in')->nullable();
      $table->date('date_out')->nullable();
      $table->date('date_sold')->nullable();
      $table->date('date_billed')->nullable();
      $table->decimal('purchase_price_soll', 9, 2)->nullable();
      $table->decimal('purchase_price_ist', 9, 2)->nullable();
      $table->decimal('purchase_price_frame', 9, 2)->nullable();
      $table->decimal('sale_price_soll', 9, 2)->nullable();
      $table->decimal('sale_price_ist', 9, 2)->nullable();
      $table->decimal('sale_price_internal', 9, 2)->nullable();
      $table->decimal('sale_price_frame', 9, 2)->nullable();
      $table->tinyInteger('show_exact_price')->default(0);
      $table->string('discount')->nullable();
      $table->text('info')->nullable();
      $table->text('info_arttrade')->nullable();
      $table->string('bank_account_number')->nullable();
      $table->text('bank_account_info')->nullable();
      $table->tinyInteger('position')->default(-1);
      $table->tinyInteger('publish')->default(0);
      $table->foreignId('artwork_state_id')->constrained();
      $table->foreignId('artwork_technique_id')->nullable()->constrained();
      $table->foreignId('artwork_frame_id')->nullable()->constrained();
      $table->foreignId('vat_type_id')->nullable()->constrained();
      $table->foreignId('client_id')->nullable()->constrained();
      $table->string('previous_client')->nullable();
      $table->foreignId('inventory_state_id')->nullable()->constrained();
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
    Schema::dropIfExists('artworks');
  }
};
