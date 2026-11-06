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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->string('company_logo')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('testimonial');
            $table->string('avatar')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('is_featured');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
