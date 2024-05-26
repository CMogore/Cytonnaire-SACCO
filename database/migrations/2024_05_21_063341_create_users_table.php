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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('number');
            $table->foreignId('role_id')->default(1)->constrained('roles');
            $table->foreignId('employee_status_id')->default(6)->constrained('statuses');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert([
            [
                'firstname' => 'Chelsea',
                'lastname' => 'Mogore',
                'email' => 'mogorechelsea@gmail.com',
                'password' => Hash::make('12345'),
                'number' => '0796291574',
                'role_id' => 2,
                'employee_status_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstname' => 'Terry',
                'lastname' => 'Kinuthia',
                'email' => 'twkinuthia@cytonn.com',
                'password' => Hash::make('12345'),
                'number' => '0768371577',
                'role_id' => 1,
                'employee_status_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more users as needed
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
