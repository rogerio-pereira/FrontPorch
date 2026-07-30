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
        Schema::create('case_study_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('case_study_id')
                ->constrained('case_studies')
                ->cascadeOnDelete();
            $table->string('url');
            $table->string('alt');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_study_images');
    }
};
