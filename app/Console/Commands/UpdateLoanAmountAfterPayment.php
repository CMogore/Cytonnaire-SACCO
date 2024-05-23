<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;

class UpdateLoanAmountAfterPayment extends Command
{
    protected $signature = 'loans:update-after-payment';
    protected $description = 'Update loan amount after loan payment is made';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $loanPayments = DB::table('loan_payments')->whereNull('deleted_at')->get();

        foreach ($loanPayments as $payment) {
            // Fetch the loan record
            $loan = DB::table('loans')->where('id', $payment->loan_id)->first();

            if ($loan) {
                // Update the loan amount by decrementing the payment amount
                DB::table('loans')->where('id', $payment->loan_id)->decrement('payable_amount', $payment->amount);

                // Mark the payment as processed (soft delete)
                DB::table('loan_payments')->where('id', $payment->id)->update([
                    'deleted_at' => now(),
                    'updated_at' => now(),
                ]);

                // Log information (optional)
                $this->info("Loan ID {$payment->loan_id} updated: Amount decremented by {$payment->amount}. Remaining amount: " . ($loan->payable_amount - $payment->amount));
            } else {
                // Log error if the loan is not found (optional)
                $this->error("Loan ID {$payment->loan_id} not found. Payment ID: {$payment->id}.");
            }
        }
    }
}