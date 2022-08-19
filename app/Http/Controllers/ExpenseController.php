<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Models\Expense;
use App\Models\Voucher;
use App\Models\Currencies;
use App\Models\cost_center;

class ExpenseController extends Controller
{
    //
    public function update_expense(Request $request)
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
                
        $id = $request->id;
        $voucher_number = $request->voucher_number;
        $expense_date = $request->date;
        $expense_description = $request->description;
        $currency_id = $request->currency;
        $cost_center_id = $request->dd_cost_center;
        $amount = $request->exp_amount;
        
        if ($request->bill == 0) {
            # code...
            $bill = 'Non-billable';
        } else {
            $bill = 'Billable';
        }
        $comments = $request->comment;
        
        // $expenses_result = $expenses->save();
        $expenses_result = $expenses->where('id', '=', $id)->update([
            'expense_date' => $expense_date,
            'expense_description' => $expense_description,
            'currency_id' => $currency_id,
            'cost_center_id' => $cost_center_id,
            'amount' => $amount,
            'bill' => $bill,
            'comments' => $comments
        ]);

        
        if ($expenses_result) {
            # code...
            $sum = $expenses->where('voucher_number', '=', $voucher_number)->sum('amount');
            
            $update_amount = Voucher::where('voucher_number', '=', $voucher_number)->update(['amount' => $sum]);
            
            return response()->json(['success' => true]);
        }
    }
    
    public function single_voucher_data($voucher_number)
    {
        # code...
        // $data = $voucher_number;

        $expense_data = new Expense();
        $currency = new Currencies();
        $center = new cost_center();

        $data = $expense_data->where('voucher_number', '=', $voucher_number)->get();

        $currency_name = array();

        for ($i=0; $i < sizeof($data); $i++) { 
            # code...
            $currency_id = $data[$i]->currency_id;
            $temp = $currency->where('id', '=', $currency_id)->get()->first();
            array_push($currency_name, $temp);
        }

        $center_name = array();

        for ($i=0; $i < sizeof($data); $i++) { 
            # code...
            $center_id = $data[$i]->cost_center_id;
            $temp = $center->where('id', '=', $center_id)->get()->first();
            array_push($center_name, $temp);
        }

        return response()->json(['success' => true, 'data' => $data, 'cost_currency' => $currency_name, 
                                    'cost_center' => $center_name]);
    }

    public function generate_report()
    {
        # code...
        return view('Supervisor.generate-report');
    }

    public function emps()
    {
        # code...
        return view('Supervisor.emps');
    }

    public function all_expenses()
    {
        # code...
        return view('Supervisor.all-expenses');
    }

    public function all_exps()
    {
        # code...
        $exp = Expense::all();
        $data = $exp->toArray();
        
        for ($i=0; $i < sizeof($exp); $i++) { 
            # code...
            
            $email = Voucher::where('voucher_number', '=', $exp[$i]->voucher_number)->get()->first();

            $currency = Currencies::where('id', '=', $exp[$i]->currency_id)->get()->first();
            
            $cost_center = cost_center::where('id', '=', $exp[$i]->cost_center_id)->get()->first();
            
            $data[$i] = Arr::add($data[$i], 'email_address', $email->emp_email);
            $data[$i] = Arr::add($data[$i], 'currency_name', $currency->currency_name);
            $data[$i] = Arr::add($data[$i], 'cost_center_name', $cost_center->center_name);

        }

        return response()->json(['success' => 1, 'data' => $data]);
    }

}
