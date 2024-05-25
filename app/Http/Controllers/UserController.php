<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\LoanRepaymentConfirmation;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Share;
use App\Models\ShareTransfer;
use App\Models\LoanRequest;
use App\Models\Loan;
use App\Models\Contribution;
use App\Models\Status;
use App\Models\LoanType;
use App\Models\LoanPayment;
use App\Models\Role;
use App\Models\Saving;


class UserController extends Controller
{
    public function buyShares(Request $request)
    {
        $validatedData = $request->validate([
            'total_shares' => 'required|numeric|min:0',
        ]);

        // Find the existing share record for the authenticated user
        $share = Share::where('user_id', Auth::id())->first();

        if ($share) {
            // Update the existing share record
            $share->total_shares += $validatedData['total_shares'];
            $share->save();
        } else {
            // Create a new share record if one does not exist
            $share = Share::create([
                'user_id' => Auth::id(),
                'total_shares' => $validatedData['total_shares'],
            ]);
        }

        return response()->json($share, 201);
    }

    public function makeContribution(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Create the contribution record
        $contribution = Contribution::create([
            'user_id' => Auth::id(),
            'amount' => $validatedData['amount'],
            'contribution_date' => Carbon::now(),
        ]);

        // Check if the user exists in the savings table
        $savings = Saving::where('user_id', Auth::id())->first();

        if ($savings) {
            // If user exists, update the total_savings
            $savings->total_savings += $validatedData['amount'];
            $savings->save();
        } else {
            // If user doesn't exist, insert a new record
            Saving::create([
                'user_id' => Auth::id(),
                'total_savings' => $validatedData['amount'],
            ]);
        }

        return response()->json($contribution, 201);
    }

    public function transferShares(Request $request)
    {
        $validatedData = $request->validate([
            'to_user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $fromUserId = Auth::id();
        $toUserId = $validatedData['to_user_id'];
        $amount = $validatedData['amount'];

        // Check if the from_user_id has enough shares
        $share = Share::where('user_id', $fromUserId)->first();

        if (!$share || $share->total_shares < $amount) {
            return response()->json(['error' => 'Insufficient shares'], 400);
        }

        // Deduct shares from from_user_id
        $share->total_shares -= $amount;
        $share->save();

        // Add shares to to_user_id or create a new record
        $toShare = Share::firstOrNew(['user_id' => $toUserId]);
        $toShare->total_shares += $amount;
        $toShare->save();

        // Record the transfer
        $transfer = ShareTransfer::create([
            'from_user_id' => $fromUserId,
            'to_user_id' => $toUserId,
            'amount' => $amount,
            'date' => Carbon::now(),
        ]);

        return response()->json($transfer, 201);
    }

    public function getLatestContributions(Request $request)
{
    $user_id = Auth::id();
    $firstDay = now()->startOfMonth()->toDateString();
    $lastDay = now()->endOfMonth()->toDateString();

    $contributions = Contribution::where('user_id', $user_id)
        ->whereBetween('contribution_date', [$firstDay, $lastDay])
        ->orderBy('contribution_date', 'desc')
        ->take(5)
        ->get();

    return response()->json($contributions);
}
public function getActiveLoans(Request $request)
{
    $user_id = Auth::id();

    $loans = Loan::where('user_id', $user_id)
        ->where('status_id', 5)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($loans);
}

public function getLatestPayments(Request $request)
{
    $user_id = Auth::id();
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    $payments = LoanPayment::join('loans', 'loan_payments.loan_id', '=', 'loans.id')
        ->where('loans.user_id', $user_id)
        ->whereBetween('loan_payments.payment_date', [$startOfMonth, $endOfMonth])
        ->orderBy('loan_payments.payment_date', 'desc')
        ->select('loan_payments.*')  // Ensure that we select only the columns from payments table
        ->take(5)
        ->get();

    return response()->json($payments);
}

public function getMadeContributions(Request $request)
    {
        $user_id = Auth::id();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $contributions = Contribution::where('user_id', $user_id)
            ->whereBetween('contribution_date', [$startOfMonth, $endOfMonth])
            ->orderBy('contribution_date', 'desc')
            ->get();

        return response()->json($contributions);
    }

    public function getPendingContributions(Request $request)
    {
        $user_id = Auth::id();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $minimumContribution = 500;

        $totalContributions = Contribution::where('user_id', $user_id)
            ->whereBetween('contribution_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $pendingContribution = $minimumContribution - $totalContributions;
        $pendingContribution = $pendingContribution > 0 ? $pendingContribution : 0;

        return response()->json(['pending_contribution' => $pendingContribution]);
    }

    public function getContributionsBetweenDates(Request $request)
    {
        $user_id = Auth::id();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $contributions = Contribution::where('user_id', $user_id)
            ->whereBetween('contribution_date', [$startDate, $endDate])
            ->orderBy('contribution_date', 'asc')
            ->get();

        return response()->json($contributions);
    }

    public function createLoanRequest(Request $request)
{
    $validatedData = $request->validate([
        'amount' => 'required|numeric|min:0',
        'payable_amount' => 'required|numeric|min:0',
        'payment_period' => 'required|integer|min:0',
        'type_id' => 'required|exists:loan_types,id',
        'payment_per_month' => 'required|numeric|min:0',
    ]);

    $userId = auth()->id();

    // Retrieve the total savings of the authenticated user
    $totalSavings = Saving::where('user_id', $userId)->sum('total_savings');

    // Check if the requested loan amount is greater than the total savings
    if ($validatedData['amount'] > $totalSavings) {
        return response()->json(['error' => 'Insufficient funds.'], 400);
    }

    // Calculate the total loan amount (including the requested loan)
    $totalLoansAmount = LoanRequest::where('user_id', $userId)
                        ->where('status_id', 5)
                        ->sum('amount');

    // Check if the total loan amount exceeds the total savings
    if (($totalLoansAmount + $validatedData['amount']) > $totalSavings) {
        return response()->json(['error' => 'Loan limit reached.'], 400);
    }

    // Create the loan request
    $loanRequest = LoanRequest::create([
        'user_id' => $userId,
        'amount' => $validatedData['amount'],
        'payable_amount' => $validatedData['payable_amount'],
        'payment_period' => $validatedData['payment_period'],
        'type_id' => $validatedData['type_id'],
        'payment_per_month' => $validatedData['payment_per_month'],
        'contribution_date' => now(), // Current date
    ]);

    return response()->json($loanRequest, 201);
}
    public function getLoanTypes()
    {
        $loanTypes = LoanType::all();
        return response()->json($loanTypes);
    }

    public function getUserLoans()
{
    $user = auth()->user();
    $loans = Loan::with(['status', 'type'])->where('user_id', $user->id)->where('status_id', 5)->get();
    return response()->json($loans);
}
public function makeLoanPayment(Request $request)
{
    $validatedData = $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'amount' => 'required|numeric|min:0',
    ]);

    // Check if the authenticated user owns the loan
    $user = auth()->user();
    $loan = Loan::findOrFail($validatedData['loan_id']);
    if ($loan->user_id !== $user->id) {
        return response()->json(['error' => 'Unauthorized.'], 401);
    }

    // Ensure the payment amount is not more than the payable amount
    if ($validatedData['amount'] > $loan->payable_amount) {
        return response()->json(['error' => 'Payment amount exceeds payable amount.'], 400);
    }

    // Create the loan payment record
    $loanPayment = LoanPayment::create([
        'loan_id' => $validatedData['loan_id'],
        'amount' => $validatedData['amount'],
        'payment_date' => now(),
    ]);

    // Deduct payment amount from loan's payable amount
    $loan->payable_amount -= $validatedData['amount'];

    // Check if the payable amount is zero and update status
    if ($loan->payable_amount <= 0) {
        $loan->status_id = 2; // Change status to 2 (fully settled)
    }

    $loan->save();

   // Send email confirmation
   Mail::to($user->email)->send(new LoanRepaymentConfirmation($loan, $loanPayment));

   return response()->json($loanPayment, 201);

}

//loans 
public function getUserLoanRequests()
{
    $user = auth()->user();
    $loanRequests = LoanRequest::with(['status', 'type'])->where('user_id', $user->id)->get();
    return response()->json($loanRequests);
}
public function getUserLoanPayments()
{
    $user_id = Auth::id();
    

    $payments = LoanPayment::join('loans', 'loan_payments.loan_id', '=', 'loans.id')
        ->where('loans.user_id', $user_id)
        ->orderBy('loan_payments.created_at', 'desc')
        ->select('loan_payments.*')  // Ensure that we select only the columns from payments table
        ->get();

    return response()->json($payments);
}


public function getNotifications()
    {
        $userId = Auth::id();
        
        // Fetch loan requests made by the user
        $loanRequests = LoanRequest::where('user_id', $userId)
            ->where('status_id', 1) // Assuming 1 is the status for pending requests
            ->orderBy('created_at', 'desc')
            ->get(['id', 'amount', 'created_at']);

        // Fetch loan requests status changes
        $loanStatusChanges = LoanRequest::where('user_id', $userId)
            ->whereIn('status_id', [3, 4]) 
            ->get(['id', 'amount', 'status_id', 'comment', 'updated_at']);

        // Fetch upcoming loan payments
        $upcomingPayments = Loan::where('user_id', $userId)
            ->where('status_id', 5) // Assuming 5 is the active status
            ->where('payable_amount', '>', 0)
            ->get(['id', 'amount', 'payment_per_month']);

        // Combine notifications
        $notifications = [];

        foreach ($loanRequests as $request) {
            $notifications[] = [
                'message' => 'Loan request of ' . $request->amount . ' is pending.',
                'date' => $request->created_at->format('Y-m-d H:i:s')
            ];
        }

        foreach ($loanStatusChanges as $loan) {
            if ($loan->status_id == 3) {
                $statusMessage = 'approved';
            } elseif ($loan->status_id == 4) {
                $statusMessage = 'rejected';
                $rejectionComment = $loan->rejection_comment;
            }

            $notifications[] = [
                'message' => 'Your loan of ' . $loan->amount . ' has been ' . $statusMessage . '. ' . ($loan->status_id == 3 ? 'Comment: ' . $rejectionComment : ''),
                'date' => $loan->updated_at->format('Y-m-d H:i:s')
            ];
        }

        foreach ($upcomingPayments as $payment) {
            $notifications[] = [
                'message' => 'Upcoming payment of ' . $payment->payment_per_month . ' due soon.',
                'date' => now()->format('Y-m-d H:i:s')
            ];
        }

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => count($notifications)
        ]);
    }

    public function markAllAsRead()
    {
        // Since we don't have a dedicated notifications table,
        // we just return a success response.
        return response()->json(['status' => 'success']);
    }



}