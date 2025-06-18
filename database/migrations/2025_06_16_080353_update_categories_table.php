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
        Schema::table('categories', function (Blueprint $table) {
            // Drop existing columns if they exist
            if (Schema::hasColumn('categories', 'category_name')) {
                $table->dropColumn('category_name');
            }
            if (Schema::hasColumn('categories', 'description')) {
                $table->dropColumn('description');
            }
            
            // Add new columns
            $table->string('name', 128)->after('id');
            $table->string('slug', 128)->unique()->after('name');
            $table->text('description')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['name', 'slug', 'description']);
            
            // Add back original columns
            $table->string('category_name', 128)->after('id');
            $table->string('description', 255)->after('category_name');
        });
    }
};
