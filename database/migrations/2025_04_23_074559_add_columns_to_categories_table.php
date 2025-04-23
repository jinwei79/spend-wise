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
        Schema::table('expense_categories', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('description')->constrained()->onDelete('cascade'); // Link to users table
            $table->string('color_code')->nullable()->after('description');
            $table->boolean('is_default')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_categories', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('is_default');
            $table->dropColumn('color_code');
        });
    }
};
