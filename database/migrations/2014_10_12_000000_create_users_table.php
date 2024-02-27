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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role', 45);
            $table->string('whats', 20)->nullable();
            $table->string('facebook', 120)->nullable();
            $table->string('instagram', 120)->nullable();
            $table->string('x', 120)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('imagen', 120)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
