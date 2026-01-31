<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id') // cashier/admin who sold
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('customer_id')->nullable(); // optional member/customer (can add FK later)

            $table->string('invoice_number')->unique();

            $table->decimal('total_amount', 12, 2)->default(0); // subtotal
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('final_total', 12, 2)->default(0);

            $table->enum('payment_type', ['cash', 'qr', 'card'])->default('cash');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};