<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/test-me", function () {
    return 'Hello from Laravel!';
});
// Login route
Route::post('/login', [AuthController::class, 'login']);

// Register route
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::get('/admin');
//     Route::get('/home', [AdminController::class, 'home']);
//     // Add more routes here...
// });
// Route::middleware(['auth:sanctum', 'admin'])->get('/admin');
// Route::middleware(['auth:sanctum', 'admin'])->get('/home');
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'home']);
    Route::get('/admin/users', [AdminController::class, 'getUsers']);
    Route::post('/admin/create', [AdminController::class, 'createUser']);
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);

    Route::get('/admin/contributions', [AdminController::class, 'getContributions']);
    Route::get('/admin/loanrequests', [AdminController::class, 'getLoanRequests']);
    Route::post('/admin/loanrequests/{id}/accept', [AdminController::class, 'acceptLoanRequest']);
    Route::post('/admin/loanrequests/{id}/reject', [AdminController::class, 'rejectLoanRequest']);

    Route::get('/admin/statuses', [AdminController::class, 'getStatuses']);
    Route::post('/admin/createstatus', [AdminController::class, 'createStatus']);
    Route::put('/admin/status/{id}', [AdminController::class, 'updateStatus']);
    Route::delete('/admin/deletestatus/{id}', [AdminController::class, 'deleteStatus']);

    Route::get('/admin/roles', [AdminController::class, 'getRoles']);
    Route::post('/admin/createrole', [AdminController::class, 'createRole']);
    Route::put('/admin/role/{id}', [AdminController::class, 'updateRole']);
    Route::delete('/admin/deleterole/{id}', [AdminController::class, 'deleteRole']);

    Route::get('/admin/loantypes', [AdminController::class, 'getLoanTypes']);
    Route::post('/admin/createloantype', [AdminController::class, 'createLoanType']);
    Route::put('/admin/loantype/{id}', [AdminController::class, 'updateLoantype']);
    Route::delete('/admin/deleteloantype/{id}', [AdminController::class, 'deleteLoanType']);

    Route::get('/admin/loans', [AdminController::class, 'getLoans']);

    Route::get('/admin/shares', [AdminController::class, 'getShares']);

    Route::get('/admin/sharetransfers', [AdminController::class, 'getShareTransfers']);

    Route::get('/admin/loanpayments', [AdminController::class, 'getLoanPayments']);





});
// Route::get('/admin/home', [AdminController::class, 'home']);


Route::middleware('auth:sanctum', 'member')->get('/member', [UserController::class, 'dashboard']);

Route::middleware(['auth:sanctum', 'member'])->group(function () {

    Route::get('/user/home', [UserController::class, 'home']);
    Route::post('/user/buyshares', [UserController::class, 'buyShares']);
    Route::post('/user/makecontributions', [UserController::class, 'makeContribution']);
    Route::post('/user/sharetransfers', [UserController::class, 'transferShares']);
    Route::get('/user/latestcontributions', [UserController::class, 'getLatestContributions']);
    Route::get('/user/activeloans', [UserController::class, 'getActiveLoans']);
    Route::get('/user/latestpayments', [UserController::class, 'getLatestPayments']);
    Route::get('/user/made-contributions', [UserController::class, 'getMadeContributions']);
    Route::get('/user/pending-contributions', [UserController::class, 'getPendingContributions']);
    Route::get('/user/getcontributionbetweendates', [UserController::class, 'getContributionsBetweenDates']);
    Route::post('/user/loan-requests', [UserController::class, 'createLoanRequest']);
    Route::get('/user/loan-types', [UserController::class, 'getLoanTypes']);
    Route::get('/user/loans', [UserController::class, 'getUserLoans']);

    // Make loan payment
    Route::post('/user/loan-payments', [UserController::class, 'makeLoanPayment']);
    Route::get('/user/loan-repayments', [UserController::class, 'getUserLoanPayments']);
    Route::get('/user/loan-requests', [UserController::class, 'getUserLoanRequests']);

    Route::get('/user/notifications', [UserController::class, 'getNotifications']);
    Route::post('/user/notifications/mark-all-read', [UserController::class, 'markAllAsRead']);

    Route::get('/user/stats', [UserController::class,'getUserStats']);



});
