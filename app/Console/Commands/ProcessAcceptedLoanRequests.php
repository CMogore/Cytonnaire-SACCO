<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessAcceptedLoanRequests extends Command
{
    protected $signature = 'loans:process-accepted';
    protected $description = 'Move accepted loan requests to the loans table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $acceptedStatusId = DB::table('statuses')->where('name', 'approved')->value('id');
        $loanRequests = DB::table('loan_requests')
                          ->where('status_id', $acceptedStatusId)
                          ->whereNull('deleted_at')
                          ->get();

        foreach ($loanRequests as $request) {
            DB::table('loans')->insert([
                'user_id' => $request->user_id,
                'amount' => $request->amount,
                'payable_amount' => $request->payable_amount,
                'type_id' => $request->type_id,
                'status_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('loan_requests')->where('id', $request->id)->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Accepted loan requests have been moved to loans table.');
    }
}