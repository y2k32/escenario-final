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
        //
        Schema::create('user_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->reference('id')->on('users');
            $table->integer('rol')->nullable();
            $table->string('code')->nullable();
            $table->string('encrypt_code')->nullable();
            $table->string('appcode')->nullable();
            $table->string('encrypt_appcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('user_codes');
    }
};
