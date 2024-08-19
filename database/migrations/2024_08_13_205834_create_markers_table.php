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

            // reserve type
            $table->integer('reserve_meters')->default(1);

            // nap type
            $table->integer('nap_buffer')->default(1);
            $table->integer('nap_thread')->default(1);
            $table->integer('nap_ports')->default(16);

            $table->foreignId('map_id')->constrained('maps');
        });
    }


    public function down()
    {
        Schema::dropIfExists('markers');
    }
};
