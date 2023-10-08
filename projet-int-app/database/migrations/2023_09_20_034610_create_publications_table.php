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
        Schema::create('publications', function (Blueprint $table) {
            //id
            $table->id();
            
            //Publication info
            ///////////////////////////////////////////
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->date('expirationOfBid')->nullable()->default(NULL);
            $table->string('postalCode');
            //Public, private, deleted by admin etc
            $table->string('publicationStatus');
            $table->tinyInteger('hidden');
            ///////////////////////////////////////////

            //Constraints FOREIGN KEY             colomn      Table 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            //Car informations
            $table->integer('fixedPrice');
            $table->integer('kilometer');
            $table->string('bodyType');
            $table->string('transmission');
            $table->string('brand');
            $table->string('color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
