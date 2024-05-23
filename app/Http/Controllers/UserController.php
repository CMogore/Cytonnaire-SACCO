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

        $contribution = Contribution::create([
            'user_id' => Auth::id(),
            'amount' => $validatedData['amount'],
            'contribution_date' => Carbon::now(),
        ]);

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


}