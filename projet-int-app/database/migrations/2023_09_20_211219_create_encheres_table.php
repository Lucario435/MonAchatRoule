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
        Schema::create('encheres', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger("userid");
            $table->foreign("userid")->references("id")->on("users");
            $table->float("prix")->default(0);
            $table->unsignedBigInteger("annonces_id")->nullable();
            $table->foreign("annonces_id")->references("id")->on("annonces");
            $table->string('mcontent', 1024)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encheres');
    }
};
