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
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id(); // Primary key with auto-increment
            $table->foreignId('loan_id')->constrained('loans'); // Foreign key to loans table
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->timestamps();
            $table->softDeletes(); // Soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
