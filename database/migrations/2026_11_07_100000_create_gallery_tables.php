<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('gallery_categories')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('alt_text')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('show_on_home')->default(false);
            $table->unsignedInteger('home_order')->default(0);
            $table->unsignedInteger('order')->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();

            $table->index(['status', 'order']);
            $table->index(['show_on_home', 'home_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('gallery_categories');
    }
};
