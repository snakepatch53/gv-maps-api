<?php

use App\Models\Fiber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('fibers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->nullable();
            $table->enum('type', Fiber::$_TYPES)->default(Fiber::$_TYPES[0]);
            $table->integer('threads')->default(1);
            $table->string('serie')->nullable();
            $table->text('description')->nullable();

            $table->foreignId('map_id')->constrained('maps');
        });
    }


    public function down()
    {
        Schema::dropIfExists('fibers');
    }
};
