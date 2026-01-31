<?php

// database/migrations/xxxx_xx_xx_add_payment_fields_to_sales.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('payment_type');
            $table->string('payment_ref')->nullable()->after('payment_status');
            $table->timestamp('paid_at')->nullable()->after('payment_ref');
        });
    }

    public function down(): void {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['payment_status','payment_ref','paid_at']);
        });
    }
};