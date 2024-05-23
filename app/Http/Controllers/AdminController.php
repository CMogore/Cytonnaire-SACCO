<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Share;
use App\Models\ShareTransfer;
use App\Models\LoanRequest;
use App\Models\Loan;
use App\Models\Contribution;
use App\Models\Status;
use App\Models\LoanType;
use App\Models\Role;




class AdminController extends Controller
{
    public function home(Request $request)
    {
        $totalShares = Share::sum('total_shares');
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

    //users table
    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'number' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer',
            'employee_status_id' => 'required|integer',
        ]);

        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'number' => $validatedData['number'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => $validatedData['role_id'],
            'employee_status_id' => $validatedData['employee_status_id'],
        ]);

        return response()->json($user, 201);
    }

    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'number' => 'required|string|max:15',
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|integer',
            'employee_status_id' => 'required|integer',
        ]);

        $user = User::findOrFail($id);
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->email = $validatedData['email'];
        $user->number = $validatedData['number'];
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->role_id = $validatedData['role_id'];
        $user->employee_status_id = $validatedData['employee_status_id'];
        $user->save();

        return response()->json($user);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    //contributions
    public function getContributions()
    {
        $contributions = Contribution::where('status_id', 9)
        ->get();;
        return response()->json($contributions);
    }

    //loanrequest
    public function getLoanRequests()
    {
        $adminUserId = auth()->id();

        // Get all loan requests except those made by the current admin user
        $loanrequests = LoanRequest::where('user_id', '!=', $adminUserId)
                                    ->where('status_id', 1)
                                    ->get();

        return response()->json($loanrequests);
        ;
    }

    // 

    public function acceptLoanRequest($id)
    {
        $loanRequest = LoanRequest::findOrFail($id);
        $loanRequest->status_id = 3; // Set status to accepted
        $loanRequest->save();
    
        return response()->json(['message' => 'Loan request accepted successfully']);
    }
    
    public function rejectLoanRequest(Request $request, $id)
    {
        $loanRequest = LoanRequest::findOrFail($id);
        $loanRequest->status_id = 4; // Set status to rejected
        $loanRequest->comment = $request->comment; // Save rejection comment
        $loanRequest->save();
    
        return response()->json(['message' => 'Loan request rejected successfully']);
    }

    //statuses table
    public function getStatuses()
    {
        $statuses = Status::all();
        return response()->json($statuses);
    }

    public function createStatus(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Status::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json($status, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Status::findOrFail($id);
        $status->name = $validatedData['name'];
        $status->save();

        return response()->json($status);
    }

    public function deleteStatus($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();
        return response()->json(null, 204);
    }

    //loan types table
    public function getLoanTypes()
    {
        $statuses = LoanType::all();
        return response()->json($statuses);
    }

    public function createLoanType(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0|max:255'

        ]);

        $status = LoanType::create([
            'name' => $validatedData['name'],
            'interest_rate' => $validatedData['interest_rate'],

        ]);

        return response()->json($status, 201);
    }

    public function updateLoanType(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0|max:255'


        ]);

        $status = LoanType::findOrFail($id);
        $status->name = $validatedData['name'];
        $status->interest_rate = $validatedData['interest_rate'];

        $status->save();

        return response()->json($status);
    }

    public function deleteLoanType($id)
    {
        $status = LoanType::findOrFail($id);
        $status->delete();
        return response()->json(null, 204);
    }


    //roles table
    public function getRoles()
    {
        $statuses = Role::all();
        return response()->json($statuses);
    }

    public function createRole(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Role::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json($status, 201);
    }

    public function updateRole(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Role::findOrFail($id);
        $status->name = $validatedData['name'];
        $status->save();

        return response()->json($status);
    }

    public function deleteRole($id)
    {
        $status = Role::findOrFail($id);
        $status->delete();
        return response()->json(null, 204);
    }

    //loans
    public function getLoans()
    {

        $loans = Loan::where('status_id', 5)
                                    ->get();

        return response()->json($loans);
        ;
    }

    //shares
    public function getShares()
    {
        $shares = Share::all();
        return response()->json($shares);
    }

    //sharetransfers
    public function getShareTransfers()
    {
        $sharetransfers = ShareTransfer::all();
        return response()->json($sharetransfers);
    }

}
