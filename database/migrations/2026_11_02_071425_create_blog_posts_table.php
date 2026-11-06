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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('category_id')->nullable()->constrained('blog_categories')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('featured_image');
            $table->enum('layout', ['full', 'left_sidebar', 'right_sidebar'])->default('right_sidebar');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('reading_time')->nullable();
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->dateTime('publish_date');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('likes')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('author_id');
            $table->index('category_id');
            $table->index('slug');
            $table->index('status');
            $table->index('publish_date');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
