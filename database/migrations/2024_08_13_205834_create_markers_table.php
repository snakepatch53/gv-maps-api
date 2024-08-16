<?php

use App\Models\Marker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('markers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->text('description')->nullable();
            $table->enum('type', Marker::$_TYPES)->default(Marker::$_TYPES[0]);

            $table->integer('reserve_meters')->nullable();
            $table->integer('nap_threads')->nullable();
            $table->integer('nap_buffers')->nullable();
            $table->integer('nap_ports')->nullable();

            $table->foreignId('map_id')->constrained('maps');
        });
    }


    public function down()
    {
        Schema::dropIfExists('markers');
    }
};
