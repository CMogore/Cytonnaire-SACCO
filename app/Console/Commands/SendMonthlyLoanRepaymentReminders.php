<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonthlyLoanRepaymentReminder;
use App\Models\Loan;
use Carbon\Carbon;

class SendMonthlyLoanRepaymentReminders extends Command
{
    protected $signature = 'send:monthly-loan-repayment-reminders';
    protected $description = 'Send monthly reminders for loan repayments';

    public function handle()
    {
        try {
            // Fetch loans with pending payments
            $loans = Loan::with('user')
                ->where('status_id', 5) // Active loans
                ->where('payable_amount', '>', 0) // Loans with remaining payments
                ->get();

            // Check if there are any loans to send reminders for
            if ($loans->isEmpty()) {
                $this->info('No loans require repayment reminders.');
                return;
            }

            // Iterate over loans and send reminders
            foreach ($loans as $loan) {
                $this->sendReminderEmail($loan);
            }

            $this->info('Monthly loan repayment reminders sent successfully.');
        } catch (\Exception $e) {
            $this->error('Error sending monthly loan repayment reminders: ' . $e->getMessage());
        }
    }

    private function sendReminderEmail($loan)
    {
        // Check if user has an email address
        if (!$loan->user || !$loan->user->email) {
            $this->warn('User email not found for loan: ' . $loan->id);
            return;
        }

        // Send reminder email
        try {
            Mail::to($loan->user->email)->send(new MonthlyLoanRepaymentReminder($loan));
            $this->info('Reminder email sent for loan: ' . $loan->id);
        } catch (\Exception $e) {
            $this->error('Error sending reminder email for loan ' . $loan->id . ': ' . $e->getMessage());
        }
    }
}
