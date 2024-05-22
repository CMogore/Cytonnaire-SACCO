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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id(); // Primary key with auto-increment
            $table->foreignId('user_id')->constrained('users'); // Foreign key to users table
            $table->decimal('amount', 10, 2);
            $table->date('contribution_date');
            $table->foreignId('status_id')->default(9)->constrained('statuses'); // Foreign key to statuses table
            $table->timestamps();
            $table->softDeletes(); // Soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
