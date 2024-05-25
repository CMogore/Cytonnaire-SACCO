<!-- resources/views/emails/loan_repayment_confirmation.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Loan Repayment Confirmation</title>
</head>
<body>
    <h1>Loan Repayment Confirmation</h1>
    <p>Dear Member,</p>
    <p>Thank you for your repayment of ksh{{ $repayment->amount }} towards your loan (Loan ID: {{ $loan->id }}).</p>
    <p>Remaining Payable Amount: ksh{{ $loan->payable_amount }}</p>
    <p>Date: {{ $repayment->payment_date }}</p>
    <p>Thank you for your prompt payment.</p>
</body>
</html>
