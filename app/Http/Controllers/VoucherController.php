<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Voucher;
use App\Models\Expense;
use App\Models\user;
use App\Models\Currencies;
use App\Models\cost_center;
use App\Models\supervisor;
use Session;

class VoucherController extends Controller
{
    //
    public function generate_voucher(Request $request)
    {
        # code...

        $validator = Validator::make($request->all(),[
            'voucher_description' => 'required'
        ]);

        if ($validator->fails()) {
        //     # code...
            return response()->json(['validation_error' => true]);
        }

        $voucher = new Voucher();

        $email = $request->session()->get('email');  

        $voucher->voucher_number = rand(100000, 1000000);

        $voucher->emp_email = $email; 
        $voucher->voucher_date = date('Y-m-d'); 
        $voucher->voucher_description = $request->voucher_description; 
        $voucher->amount = 0; 
        $voucher->advance_payment = 0; 
        $voucher->status = 'pending'; 
        
        $voucher_result = $voucher->save();

        $request->session()->put('voucherNo', $voucher->voucher_number);

        if ($voucher_result) {
            # code...
            return response()->json(['navigate' => true]);
        }
    }

    public function expense_page()
    {
        # code...
        return view("Employeer.expense");
    }

    public function currency_cost_center()
    {
        # code...
        $currencies = Currencies::get();
        $cost_center = cost_center::get();
        return response()->json(['currencies' => $currencies, 'cost_center' => $cost_center]);
    }

    public function save_data(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(),[
            'date' => 'required',
            'description' => 'required',
            'currency' => 'required',
            'dd_cost_center' => 'required',
            'exp_amount' => 'required',
            'bill' => 'required',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
        //     # code...
            return response()->json(['validation_error' => true]);
        }
        
        $expenses = new Expense();
        
        $v_num = $request->session()->get('voucherNo');
        
        $expenses->voucher_number = $v_num;
        $expenses->expense_date = $request->date;
        $expenses->expense_description = $request->description;
        $expenses->currency_id = $request->currency;
        $expenses->cost_center_id = $request->dd_cost_center;
        $expenses->amount = $request->exp_amount;
        
        if ($request->bill == 0) {
            # code...
            $expenses->bill = 'Non-billable';
        } else {
            $expenses->bill = 'Billable';
        }
        $expenses->comments = $request->comment;
        
        $expenses_result = $expenses->save();

        if ($expenses_result) {
            # code...
            $sum = $expenses->where('voucher_number', '=', $v_num)->sum('amount');

            $update_amount = Voucher::where('voucher_number', '=', $v_num)->update(['amount' => $sum]);

            if ($update_amount) {
                # code...
                return response()->json(['success' => true]);
            }
        }
    }

    public function review_voucher()
    {
        # code...
        return view('Employeer.review_voucher');
    }

    public function review_details(Request $request)
    {
        # code...
        $v_num = $request->session()->get('voucherNo');
        $emp_id = user::where('email', '=', $request->session()->get('email'))->first();
        $name = $emp_id->fname . ' ' . $emp_id->lname;
        $voucher = Voucher::where('voucher_number', '=', $v_num)->get()->first();
        $expense = Expense::where('voucher_number', '=', $v_num)->get();

        return response()->json(['voucher_number' => $v_num, 'employee_name' => $name,
            'voucher' => $voucher, 'expense' => $expense]);
    }

    public function history_voucher()
    {
        # code...
        return view('Employeer.history-voucher');
    }

    public function voucher_details()
    {
        # code...
        $voucher = Voucher::all();
        return response()->json(['success' => true, 'voucher' => $voucher]);
    }
    
    public function list_vouchers(Request $request)
    {
        # code...
        // $voucher = Voucher::all();
        $voucher = Voucher::where('status', '=', 'Pending')->orwhere('status', '=', 'pending')->get();
        return response()->json(['success' => true, 'voucher' => $voucher]);
    }

    public function single_voucher($voucher_number)
    {
        # code...
        return view('Employeer.single-voucher');
    }

    public function single_voucher_details(Request $request, $v_number)
    {
        # code...
        $emp_id = user::where('email', '=', $request->session()->get('email'))->first();
        $name = $emp_id->fname . ' ' . $emp_id->lname;
        $voucher = Voucher::where('voucher_number', '=', $v_number)->get()->first();
        $expense = Expense::where('voucher_number', '=', $v_number)->get();

        return response()->json(['voucher_number' => $v_number, 'employee_name' => $name,
            'voucher' => $voucher, 'expense' => $expense]);
    }

    public function edit_voucher($voucher_number, $exp_num)
    {
        # code...
        return view('Employeer.edit-voucher');
    }

    public function get_single_data($exp_number)
    {
        # code...
        $exp_record = Expense::where('id', '=', $exp_number)->get()->first();
        return response()->json(['expense_record' => $exp_record]);
    }

    public function view_vouchers()
    {
        # code...
        return view('Supervisor.view_vouchers');
    }

    public function single_voucher_supervisor($voucher_number)
    {
        # code...
        return view('Supervisor.single_voucher_supervisor');
    }

    public function approve_voucher($voucher_number)
    {
        # code...
        $update_amount = Voucher::where('voucher_number', '=', $voucher_number)->update(['status' => 'Approved']);
        return response()->json(['success' => true]);
    }

    public function reject_voucher($voucher_number)
    {
        # code...
        $update_amount = Voucher::where('voucher_number', '=', $voucher_number)->update(['status' => 'Rejected']);
        return response()->json(['success' => true]);
    }

    public function single_emp($email)
    {
        # code...
        return view('Supervisor.single_emp');
    }

    public function single_emp_voucher_details($email)
    {
        # code...
        
        $data = Voucher::where('emp_email', '=', $email)->where('status', '=', 'Approved')->orWhere('status', '=', 'Rejected')->get();

        return response()->json(['success' => 1, 'data' => $data]);
    }

    public function all_vouchers()
    {
        # code...
        return view('Supervisor.all-vouchers');
    }

    public function all_voucher_details()
    {
        # code...
        $data = Voucher::all();
        
        return response()->json(['success' => 1, 'data' => $data]);
    }

}
