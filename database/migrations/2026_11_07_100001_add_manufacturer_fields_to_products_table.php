<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand', 100)->nullable()->after('name');
            $table->string('model')->nullable()->after('brand');
            $table->json('applications')->nullable()->after('specifications');
            $table->string('manufacturer_url', 500)->nullable()->after('applications');
            $table->string('datasheet_url', 500)->nullable()->after('manufacturer_url');
            $table->string('source_url', 500)->nullable()->after('datasheet_url');

            $table->index('brand');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['brand']);
            $table->dropColumn(['brand', 'model', 'applications', 'manufacturer_url', 'datasheet_url', 'source_url']);
        });
    }
};
