<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\user;
use App\Models\Voucher;

class UserController extends Controller
{
    //
    public function list_emps()
    {
        # code...
        $emp = user::all();
        
        $data = array();
        
        for ($i=0; $i < sizeof($emp); $i++) { 
            # code...
            $temp = array();
            
            $temp = Arr::add($temp, 'Name', $emp[$i]->fname . ' ' . $emp[$i]->lname);
            $temp = Arr::add($temp, 'Email Address', $emp[$i]->email);

            $amount = Voucher::where('emp_email', '=', $emp[$i]->email)->where('status', '=', 'Approved')->orWhere('status', '=', 'Rejected')->sum('amount');

            $temp = Arr::add($temp, 'Amount', $amount);
            array_push($data, $temp);
        }


        return response()->json(['success' => 1, 'data' => $data]);
    }
}
