<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('division_id')->nullable()->after('phone')->constrained()->nullOnDelete();
            $table->foreignId('district_id')->nullable()->after('division_id')->constrained()->nullOnDelete();
            $table->foreignId('upazila_id')->nullable()->after('district_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['upazila_id']);
            $table->dropColumn(['division_id', 'district_id', 'upazila_id']);
        });
    }
};
