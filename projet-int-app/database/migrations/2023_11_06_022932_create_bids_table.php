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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();

            //Needs publication_id and user_id

            //Constraints FOREIGN KEY             colomn      Table 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger("publication_id")->nullable();
            $table->foreign("publication_id")->references("id")->on("publications");

            ///////////////////////////////////////////////////////////////
            //Bid informations
            $table->integer('priceGiven');
            $table->string("bidStatus");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
