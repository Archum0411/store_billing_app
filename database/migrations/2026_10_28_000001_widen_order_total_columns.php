<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->change();
            $table->decimal('tax_total', 12, 2)->change();
            $table->decimal('grand_total', 12, 2)->change();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        $hasUnrepresentableTotals = DB::table('orders')
            ->where(function ($query) {
                foreach (['subtotal', 'tax_total', 'grand_total'] as $column) {
                    $query->orWhere($column, '>', 99)
                        ->orWhere($column, '<', -99)
                        ->orWhereRaw("$column <> ROUND($column, 0)");
                }
            })
            ->exists();

        if ($hasUnrepresentableTotals) {
            throw new RuntimeException(
                'Cannot restore order totals to decimal(2,0): existing values would be lost.'
            );
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 2, 0)->change();
            $table->decimal('tax_total', 2, 0)->change();
            $table->decimal('grand_total', 2, 0)->change();
        });
    }
};
