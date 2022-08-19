<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register-user', [AuthenticationController::class, 'register_user'])->name('register-user');
Route::post('/login-user', [AuthenticationController::class, 'login_user'])->name('login-user');
Route::get('/logout', [AuthenticationController::class, 'logout']);

Route::get('/currency_cost_center', [VoucherController::class, 'currency_cost_center']);
Route::post('/save_data', [VoucherController::class, 'save_data']);
Route::post('/generate_voucher', [VoucherController::class, 'generate_voucher']);
Route::get('/review_details', [VoucherController::class, 'review_details']);
Route::get('/voucher-details', [VoucherController::class, 'voucher_details']);
Route::get('/single-voucher-details/{v_number}', [VoucherController::class, 'single_voucher_details']);
Route::get('/get_single_data/{exp_number}', [VoucherController::class, 'get_single_data']);
Route::get('/list-vouchers', [VoucherController::class, 'list_vouchers']);
Route::put('/approve-voucher/{voucher_number}', [VoucherController::class, 'approve_voucher']);
Route::put('/reject-voucher/{voucher_number}', [VoucherController::class, 'reject_voucher']);
Route::get('/single-emp-voucher-details/{email}', [VoucherController::class, 'single_emp_voucher_details']);
Route::get('/all-voucher-details', [VoucherController::class, 'all_voucher_details']);

Route::post('/update-expense', [ExpenseController::class, 'update_expense']);
Route::get('/single-voucher-data/{voucher_number}', [ExpenseController::class, 'single_voucher_data']);
Route::get('/all-exps', [ExpenseController::class, 'all_exps']);

Route::get('/list-emps', [UserController::class, 'list_emps']);