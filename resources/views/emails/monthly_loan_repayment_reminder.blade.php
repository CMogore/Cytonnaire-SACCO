<!-- resources/views/emails/monthly_loan_repayment_reminder.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Loan Repayment Reminder</title>
</head>
<body>
    <h1>Monthly Loan Repayment Reminder</h1>
    <p>Dear Member,</p>
    <p>This is a reminder for your monthly loan repayment.</p>
    <p>Loan ID: {{ $loan->id }}</p>
    <p>Monthly Payment: ${{ $loan->payment_per_month }}</p>
    <p>Remaining Payable Amount: ${{ $loan->payable_amount }}</p>
    <p>Thank you for your prompt payment.</p>
</body>
</html>
