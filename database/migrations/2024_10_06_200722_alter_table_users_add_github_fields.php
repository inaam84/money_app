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
        Schema::table('users', function (Blueprint $table) {
            // Add github field after
            $table->string('github_id', 255)
                  ->after('remember_token')
                  ->unique()
                  ->nullable();
            $table->string('github_token', 255)->nullable(); 
            $table->string('github_refresh_token', 255)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('github_id');
            $table->dropColumn('github_token');
            $table->dropColumn('github_refresh_token');
        });
    }
};
