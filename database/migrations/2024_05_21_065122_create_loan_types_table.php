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
        Schema::create('loan_types', function (Blueprint $table) {
            $table->id(); // Primary key with auto-increment
            $table->string('name');
            $table->decimal('interest_rate', 5, 2);
            $table->timestamps();
            $table->softDeletes(); // Soft deletion
        });

        // Insert default loan types
        DB::table('loan_types')->insert([
            [
                'name' => 'Normal Loan',
                'interest_rate' => 0.12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emergency Loan',
                'interest_rate' => 0.15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Salary Advance',
                'interest_rate' => 0.05,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_types');
    }
};
