<?php

// app/Mail/LoanRepaymentConfirmation.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanRepaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;
    public $repayment;

    /**
     * Create a new message instance.
     *
     * @param $loan
     * @param $repayment
     */
    public function __construct($loan, $repayment)
    {
        $this->loan = $loan;
        $this->repayment = $repayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Loan Repayment Confirmation')
                    ->view('emails.loan_repayment_confirmation');
    }
}
