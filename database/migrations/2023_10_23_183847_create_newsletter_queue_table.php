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
      Schema::create('newsletter_queue', function (Blueprint $table) {
        $table->id();
        $table->string('email');
        $table->text('errors')->nullable();
        $table->tinyInteger('processed')->default(0);
        $table->foreignId('newsletter_id')->constrained();
        $table->foreignId('newsletter_subscriber_id')->nullable()->constrained();
        $table->timestamp('processed_at')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('newsletter_queue');
    }
};
