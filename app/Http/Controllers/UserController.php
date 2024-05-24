<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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



}