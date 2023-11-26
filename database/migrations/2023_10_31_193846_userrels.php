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
        Schema::create('userrels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("reltype");
            $table->unsignedBigInteger("user_sender");
            $table->foreign("user_sender")->references("id")->on("users");
            $table->unsignedBigInteger("user_target");
            $table->foreign("user_target")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userrels');
    }
};
