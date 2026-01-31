<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            // Member system (optional)
            $table->integer('points')->default(0);
            $table->boolean('is_member')->default(true);

            $table->timestamps();

            // optional unique
            // $table->unique('phone');
            // $table->unique('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};