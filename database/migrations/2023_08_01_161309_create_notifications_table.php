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
    Schema::create('notifications', function (Blueprint $table) {
      $table->id();
      $table->foreignId("sender_id")->constrained(table: 'users')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId("user_id")->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->string("type", 64)->default("ping");
      $table->unsignedBigInteger("target_id")->nullable();
      $table->boolean("unread")->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('notifications');
  }
};
