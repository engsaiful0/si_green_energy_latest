<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Columns needed by the page CMS and the category / team modules.
 * Existing rows keep working: page_sections rows default to the "home" page.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->string('page_key', 50)->default('home')->after('page_id');
            $table->index(['page_key', 'order']);
        });

        Schema::table('service_categories', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->text('qualifications')->nullable()->after('short_bio');
            $table->string('meta_title')->nullable()->after('status');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['qualifications', 'meta_title', 'meta_description']);
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('service_categories', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropIndex(['page_key', 'order']);
            $table->dropColumn('page_key');
        });
    }
};
