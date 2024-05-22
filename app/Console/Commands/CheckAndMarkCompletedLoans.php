<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckAndMarkCompletedLoans extends Command
{
    protected $signature = 'loans:check-and-mark-completed';
    protected $description = 'Check loans with zero amount and mark them as completed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $completedStatusId = 2; // Assuming 'completed' has an ID of 2

        // Fetch loans with an amount of zero
        $loans = DB::table('loans')
            ->where('payable_amount', 0)
            ->where('status_id', '!=', $completedStatusId)
            ->whereNull('deleted_at')
            ->get();

        foreach ($loans as $loan) {
            // Update the loan status to 'completed'
            DB::table('loans')->where('id', $loan->id)->update([
                'status_id' => $completedStatusId,
                'updated_at' => now(),
                'deleted_at' => now(),

            ]);

            // Log information (optional)
            $this->info("Loan ID {$loan->id} has been fully settled.");
        }
    }
}
