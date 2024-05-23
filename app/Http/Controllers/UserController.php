<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

}