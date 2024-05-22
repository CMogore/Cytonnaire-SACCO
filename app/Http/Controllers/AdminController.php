<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Share;
use App\Models\LoanRequest;
use App\Models\Loan;
use App\Models\Contribution;



class AdminController extends Controller
{
    public function home(Request $request)
    {
        $totalShares = Share::count();
        $totalLoanRequests = LoanRequest::where('status_id', 1)->count();
        $pendingContributions = Contribution::where('status_id', 9)->count();
        $totalLoans = Loan::where('status_id', 5)->count();
        $totalUsers = User::count();

        return response()->json([
            'totalShares' => $totalShares,
            'totalLoanRequests' => $totalLoanRequests,
            'totalLoans' => $totalLoans,
            'totalUsers' => $totalUsers,
            'pendingContributions' => $pendingContributions,

        ]);
    }
}
