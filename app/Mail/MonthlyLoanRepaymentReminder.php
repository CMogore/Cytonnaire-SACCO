<?php

// app/Mail/MonthlyLoanRepaymentReminder.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyLoanRepaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->subject('Monthly Loan Repayment Reminder')
                    ->view('emails.monthly_loan_repayment_reminder');
    }
}
