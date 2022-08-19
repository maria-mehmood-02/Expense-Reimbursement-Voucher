<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('MainPanel.login');
});

Route::get('/login', [AuthenticationController::class, 'login'])->middleware('alreadyloggedin');
Route::get('/register', [AuthenticationController::class, 'register'])->middleware('alreadyloggedin');
Route::get('/emp_index', [AuthenticationController::class, 'emp_index'])->middleware('loggedin');
Route::get('/sup_index', [AuthenticationController::class, 'sup_index'])->middleware('loggedin');

Route::get('/expense', [VoucherController::class, 'expense_page']);
Route::get('/review-voucher', [VoucherController::class, 'review_voucher']);
Route::get('/history-voucher', [VoucherController::class, 'history_voucher']);
Route::get('/single-voucher/{voucher_number}', [VoucherController::class, 'single_voucher']);
Route::get('/edit-voucher/{voucher_number}/{exp_num}', [VoucherController::class, 'edit_voucher']);
Route::get('/view_vouchers', [VoucherController::class, 'view_vouchers']);
Route::get('/single-voucher-supervisor/{voucher_number}', [VoucherController::class, 'single_voucher_supervisor']);
Route::get('/single-emp/{email}', [VoucherController::class, 'single_emp']);
Route::get('/all-vouchers', [VoucherController::class, 'all_vouchers']);

Route::get('/generate-report', [ExpenseController::class, 'generate_report']);
Route::get('/emps', [ExpenseController::class, 'emps']);
Route::get('/all-expenses', [ExpenseController::class, 'all_expenses']);