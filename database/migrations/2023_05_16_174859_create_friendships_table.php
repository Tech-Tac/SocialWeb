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
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId("from_id")->constrained(table: 'users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("to_id")->constrained(table: 'users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum("status", ["pending", "approved"])->default("pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
