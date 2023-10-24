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
      Schema::create('newsletter_subscribers', function (Blueprint $table) {
        $table->id();
        $table->string('firstname')->nullable();
        $table->string('lastname')->nullable();
        $table->string('email');
        $table->string('hash')->nullable();
        $table->string('salutation')->nullable();
        $table->tinyInteger('confirmed')->default(0);
        $table->tinyInteger('active')->default(0);
        $table->date('confirmed_at')->nullable();
        $table->foreignId('language_id')->nullable()->constrained('newsletter_languages');
        $table->foreignId('user_id')->nullable()->constrained('users');
        $table->softDeletes();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('newsletter_subscribers');
    }
};
