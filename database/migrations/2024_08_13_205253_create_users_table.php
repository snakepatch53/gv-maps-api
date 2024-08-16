<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->rememberToken();
            $table->timestamps();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('user')->unique();
            $table->string('password')->default(bcrypt('password'));
            $table->enum('role', User::$_ROLES)->default(User::$_ROLES[0]);

            $table->foreignId('entity_id')->constrained('entities');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
