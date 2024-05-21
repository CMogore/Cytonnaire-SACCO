<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddPendingContributions extends Command
{
    protected $signature = 'contributions:add-pending';
    protected $description = 'Add all users to the contributions table with a pending status a week before the new month begins';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $nextMonth = Carbon::now()->addMonth()->startOfMonth();
        $oneWeekBefore = $nextMonth->copy()->subWeek();

        if (Carbon::now()->greaterThanOrEqualTo($oneWeekBefore)) {
            $users = DB::table('users')->whereNull('deleted_at')->get();

            foreach ($users as $user) {
                DB::table('contributions')->insert([
                    'user_id' => $user->id,
                    'amount' => 300, 
                    'contribution_date' => $nextMonth,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->info('Pending contributions have been added for all users.');
        } else {
            $this->info('It is not time yet to add pending contributions.');
        }
    }
}
