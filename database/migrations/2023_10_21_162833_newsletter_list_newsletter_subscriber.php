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
      Schema::create('newsletter_list_newsletter_subscriber', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('list_id');
        $table->unsignedBigInteger('subscriber_id');
        $table->foreign('list_id')->references('id')->on('newsletter_lists')->onDelete('cascade');
        $table->foreign('subscriber_id')->references('id')->on('newsletter_subscribers')->onDelete('cascade');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
