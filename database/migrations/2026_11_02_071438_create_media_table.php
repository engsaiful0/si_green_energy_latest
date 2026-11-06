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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('file_name');
            $table->string('file_path', 500);
            $table->string('file_type', 50);
            $table->string('mime_type', 100);
            $table->unsignedInteger('file_size');
            $table->string('title')->nullable();
            $table->string('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->string('folder')->default('uploads');
            $table->boolean('is_dark_variant')->default(false);
            $table->foreignId('related_media_id')->nullable()->constrained('media')->onDelete('set null');
            $table->timestamps();

            $table->index('user_id');
            $table->index('file_type');
            $table->index('folder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
