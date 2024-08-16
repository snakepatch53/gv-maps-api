<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('fiber_markers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('latitude');
            $table->string('longitude');
            $table->integer('order')->default(1);


            $table->foreignId('fiber_id')->constrained('fibers')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('fiber_markers');
    }
};
