<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) { //genx
            $table->id();
            $table->string('username', 45)->nullable();
            $table->string('password', 1024)->nullable();

            $table->string('phone', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->tinyInteger('emailnotificationsenabled')->nullable()->default(1);
            $table->tinyInteger('accstatus')->nullable()->default(0);
            $table->string('displayname', 45)->nullable();
            $table->string('userimage', 256)->nullable();

            $table->timestamps();
            $table->rememberToken();
        });
    }
    public function down():void
    {
        Schema::dropIfExists('users');
    }
};
