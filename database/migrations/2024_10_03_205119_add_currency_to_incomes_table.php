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
        Schema::table('incomes', function (Blueprint $table) {
            // Add currency field as an ENUM type
            $table->enum('currency', ['USD', 'GBP', 'PKR', 'AED', 'CAD', 'EUR'])
                  ->after('amount') 
                  ->default('GBP'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
};
