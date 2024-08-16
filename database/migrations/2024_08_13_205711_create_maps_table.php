<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->text('description');

            $table->foreignId('entity_id')->constrained('entities');
            $table->foreignId('user_id')->constrained('users');
        });
    }


    public function down()
    {
        Schema::dropIfExists('maps');
    }
};
