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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger("ventes_id")->nullable();
            $table->foreign("ventes_id")->references("id")->on("ventes");

            $table->unsignedBigInteger("userid");
            $table->foreign("userid")->references("id")->on("users");
            $table->unsignedBigInteger("user_target");
            $table->foreign("user_target")->references("id")->on("users");

            $table->string('commentaire', 128)->nullable()->default('');
            $table->integer('etoiles');

            $table->unsignedBigInteger("annonces_id")->nullable();
            $table->foreign("annonces_id")->references("id")->on("annonces");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
