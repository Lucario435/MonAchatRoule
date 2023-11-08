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
        Schema::create('chatmessages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->tinyInteger('seen')->default(0);
            $table->tinyInteger('hidden')->default(0);

            $table->string('mcontent', 512)->default('');

            $table->unsignedBigInteger("publication_id")->nullable();
            $table->foreign("publication_id")->references("id")->on("publications");

            $table->unsignedBigInteger("user_sender");
            $table->foreign("user_sender")->references("id")->on("users");
            $table->unsignedBigInteger("user_receiver");
            $table->foreign("user_receiver")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatmessages');
    }
};
