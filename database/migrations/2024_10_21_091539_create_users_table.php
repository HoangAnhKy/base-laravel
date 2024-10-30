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
            $table->string("name_user");
            $table->string("birthdate");
            $table->string("email");
            $table->string("password")->nullable();
            $table->smallInteger("position");
            $table->smallInteger("del_flag")->default(UNDEL);
            $table->smallInteger("status")->default(ACTIVE);
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
