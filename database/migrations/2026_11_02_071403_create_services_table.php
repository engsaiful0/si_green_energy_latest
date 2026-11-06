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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('service_categories')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon');
            $table->text('short_description');
            $table->longText('description');
            $table->json('benefits')->nullable();
            $table->json('process_steps')->nullable();
            $table->string('featured_image');
            $table->enum('layout', ['full', 'left_sidebar', 'right_sidebar'])->default('full');
            $table->boolean('is_featured')->default(false);
            $table->decimal('price_from', 10, 2)->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
            $table->index('slug');
            $table->index('status');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
