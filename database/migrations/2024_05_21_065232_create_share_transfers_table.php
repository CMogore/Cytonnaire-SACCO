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
        Schema::create('share_transfers', function (Blueprint $table) {
            $table->id(); // Primary key with auto-increment
            $table->foreignId('from_user_id')->constrained('users'); // Foreign key to users table
            $table->foreignId('to_user_id')->constrained('users'); // Foreign key to users table
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->timestamps();
            $table->softDeletes(); // Soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_transfers');
    }
};
