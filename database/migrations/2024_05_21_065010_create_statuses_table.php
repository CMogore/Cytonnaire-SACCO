<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id(); // Primary key with auto-increment
            $table->string('name');
            $table->timestamps();
            $table->softDeletes(); // Soft deletion
        });

        // Insert default statuses
        DB::table('statuses')->insert([
            ['name' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'settled', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'approved', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'rejected', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'not settled', 'created_at' => now(), 'updated_at' => now()],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
