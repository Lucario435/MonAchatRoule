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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("titre");
            $table->string("desc",512);
            $table->float("prixFixe")->default(0);
            $table->date("date_finencheres");
            $table->string("codepostale")->nullable();
            $table->integer("annoncestatus")->default(0);

            $table->integer('km')->unsigned()->nullable()->default(0);
            $table->string('corps', 100)->nullable();
            $table->string('transmission', 100)->nullable()->default('automatique');
            $table->string('vehiclecolor', 100)->nullable()->default('white');

            $table->unsignedBigInteger("userid");
            $table->foreign("userid")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
