<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Models\user;
use Session;

class AuthenticationController extends Controller
{
    //
    public function login()
    {
        // code...
        return view("MainPanel.login");
    }

    public function register()
    {
        // code...
        return view("MainPanel.register");
    }

    public function register_user(Request $request)
    {
        // code...

        $validator = Validator::make($request->all(),[
            'user_id'=>[
                'required',
                'regex:/^([S|E]){1}-([0-9])/',
                'unique:users,user_id'],
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:20'
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json(['validation_error' => true, 'errors' => $validator->errors()]);
        }

        $user = new user();

        $user->user_id = $request->user_id;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $result = '';

        if (str::contains($request->user_id, 'S')) {
            # code...
            $user->role = 'Supervisor';
            $result = $user->save();
        } else if (str::contains($request->user_id, 'E')) {
            # code...
            $user->role = 'Employeer';
            $result = $user->save();
        }

        if ($result) {
            # code...
            return response()->json(['success' => $result], 201);
        } else {
            # code...
            return response()->json(['fail' => $result], 404);
        }
    }

    public function login_user(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json(['validation_error' => true, 'errors' => $validator->errors()]);
        }

        $user = user::where('email', '=', $request->email)->first();

        if ($user) {
            # code...
            if (Hash::check($request->password, $user->password)) {
                # code...
                    $request->session()->put('email', $user->email);
                    return Response::json(['role' => $user->role]);
            } else {
                # code...
                return response()->json(['password_error' => true]);
                // return json_decode(['success' => $result], 201);
            }
        } else {
            # code...
            return response()->json(['email_address_unregistered' => !$user]);
            // return response()->json(['success' => $result], 201);
        } 
    } 

    public function emp_index()
    {
        # code...
        return view('Employeer.emp_index');
    }

    public function sup_index()
    {
        # code...
        return view("Supervisor.sup_index");
    }

    public function logout(Request $request)
    {
        # code...
        if($request->session()->has('email')){
            # code...
            $request->session()->forget('email');
            return redirect('login');
        }
    }
}
