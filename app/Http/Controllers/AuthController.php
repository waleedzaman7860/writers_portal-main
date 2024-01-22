<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return 'ncjsncjsnc';
        $validator = Validator::make($request->all(), [
            'membership_deposite' => 'nullable',
            'referral_code' => 'nullable',
            'name' => 'nullable',
            'email' => 'nullable',
            'number' => 'nullable',
            'bep_wallet_address' => 'nullable',
            'admin_wallet_address' => 'nullable',
            'deposite_slip' => 'nullable',

        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                ->withErrors($validator)
                ->withInput();
        }



        User::create([
            'name' => $validator['name'],
            'email ' => $validator['email'],
            'auto_generate_email ' => $validator ? ['auto_generate_email'] : '',
            'phone' => $validator['number'],
            'bep_wallet_address' => $validator['bep_wallet_address'],
            'admin_wallet_address' => $validator['admin_wallet_address'],
            'deposite_slip' => $validator['deposite_slip'],

            'membership_deposite	' => $validator['membership_deposite'],
            'joining_bonus' => $validator ? ['joining_bonus'] : '',
            'status' => $validator ? ['status'] : 'pending',

        ]);
        return 'success';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function ajaxLogIn(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        // return $request->input();
        $a = User::where('email', $request->email)->where('status', 'approved')->first();
        if ($a) {
            $creds = $request->only('email', 'password');
            $c = Auth::guard('web')->attempt($creds);
            return response()->json([
                'status' => 'Success',
                'msg'=>'LogIn Successfull',
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'msg'=>'Email is not varified by admin',
            ]);
        }
    }

    public function UserLogOut()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }


}
