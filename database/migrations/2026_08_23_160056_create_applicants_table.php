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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('national_id', 10)->unique();
            $table->enum('gender', ['ذكر', 'أنثى']);
            $table->date('birth_date');
            $table->string('nationality', 100);
            $table->string('cv_path');
            $table->string('id_path');
            $table->string('status', 50)->default('جديد');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
