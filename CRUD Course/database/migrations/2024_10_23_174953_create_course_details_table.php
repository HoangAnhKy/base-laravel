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
        Schema::create('course_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("course_id");
            $table->unsignedInteger("student_id");
            $table->unsignedInteger("create_by");
            $table->unsignedInteger("update_by")->nullable();
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
        Schema::dropIfExists('course_details');
    }
};
