<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('pin_hash')->nullable();
            $table->timestamp('pin_expires_at')->nullable();
            $table->string('tier')->default('Supporter');
            $table->enum('role', ['user','admin'])->default('user');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }
};