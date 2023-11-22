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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger("user_sender");
            $table->foreign("user_sender")->references("id")->on("users");
            $table->unsignedBigInteger("user_target")->nullable();
            $table->foreign("user_target")->references("id")->on("users");

            // Admin that resolves the issue (or user)
            $table->unsignedBigInteger("user_resolved_by")->nullable();
            $table->foreign("user_resolved_by")->references("id")->on("users");

            $table->integer('status')->default(0);
            $table->string('mcontent', 512)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
