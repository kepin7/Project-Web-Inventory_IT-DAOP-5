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
        Schema::table('spare_parts', function (Blueprint $table) {
            if (!Schema::hasColumn('spare_parts', 'quantity')) {
                $table->integer('quantity')->default(1)->after('condition');
            }
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            if (!Schema::hasColumn('stock_movements', 'contract_number')) {
                $table->string('contract_number')->nullable()->after('pic_name');
            }
            if (!Schema::hasColumn('stock_movements', 'quantity')) {
                $table->integer('quantity')->default(1)->after('type');
            }
        });

        // Drop unique index on transaction_id in stock_movements if exists
        try {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->dropUnique('stock_movements_transaction_id_unique');
            });
        } catch (\Throwable $e) {
            // Index might not exist or already dropped
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            if (Schema::hasColumn('spare_parts', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            if (Schema::hasColumn('stock_movements', 'contract_number')) {
                $table->dropColumn('contract_number');
            }
            if (Schema::hasColumn('stock_movements', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};
