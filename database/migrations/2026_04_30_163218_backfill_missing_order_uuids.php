<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('orders')
            ->where(function ($query): void {
                $query->whereNull('uuid')
                    ->orWhere('uuid', '');
            })
            ->orderBy('id')
            ->eachById(function (object $order): void {
                DB::table('orders')
                    ->where('id', $order->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
