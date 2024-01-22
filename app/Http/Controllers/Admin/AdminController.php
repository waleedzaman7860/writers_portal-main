<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    //
    public function check(Request $request)
    {
        // return $req->input();
        $request->validate([

            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:5|max:50',

        ], [
            'email.exists' => 'This email is not exists on Admins table.'
        ]);

        $creds = $request->only('email', 'password');
        $c = Auth::guard('admin')->attempt($creds);
        // dd($c);
        if ($c) {
            return redirect()->route('admin.home')->with('success', 'Welcome To The Admin Panel');
        } else {
            return redirect()->back()->with('fail', 'Incorrect credentials!');
        }
    }

    public function Home()
    {
        $user = User::latest()->get();
        return view('admin.home', ['users' => $user]);
    }

    public function ChangeStatus($id)
    {

        $data = User::where('id', $id)->first();
        $name = $data->name;
        $email = $data->email;
        $password = Str::random(10);
        $password = $password;
        $status = 'approved';




        $expireTime = Carbon::now('Asia/Karachi')->subMinutes(5); // Subtract 5 minutes to simulate past time
        $currentTimeInKarachi = Carbon::now('Asia/Karachi');
        $isExpired = $currentTimeInKarachi >= $expireTime;

        $token = hash('sha256', Str::random(120));

        $verifyUrl = route('verify', [
            'token' => $token,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'status' => $status,
            'expiration' => $isExpired,

        ]);

        $message = 'Dear ' . $name . ',<br>';
        $message .= 'Thanks for signing up! We just need you to verify your email address to complete setting up your account.<br>';
        $message .= 'Please click the following link to verify your email:<br>';
        $message .= '<a href="' . $verifyUrl . '">' . $verifyUrl . '</a>';

        $mail_data = [
            'recipient' => $email,
            'subject' => 'Email Verification',
            'body' => $message,
            'actionLink' => $verifyUrl,
            'name' => $name,
            'password' => $password,
            'status' => $status,
            'expiration' => $isExpired,
            'email' => $email,
            'name' => 'ContentWriter',
        ];


        Mail::send('email-template', $mail_data, function ($message) use ($mail_data) {
            $message->to($mail_data['recipient'])
                ->from($mail_data['recipient'], $mail_data['name'])
                ->subject($mail_data['subject']);
        });

        return redirect()->back()->with('success', 'A verification email has been sent to the provided email address. Please check your inbox and follow the instructions to verify your account.');
    }



    public function verify(Request $req)
    {
        $token = $req->token;
        $name = $req->name;
        $autoGenerateEmail = $req->autoGenerateEmail;
        $status = $req->status;
        $email = $req->email;
        $password = $req->password;


        $verifyUser = User::where('email', $email)->where('status', 'approved')->first();

        if ($verifyUser) {
            return redirect('/')->with('info', 'Your email is already verified. You can now log in.')->with('varifiedEmail', $autoGenerateEmail);
        } else {
            User::where('email', $email)->first()->update([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'token' => $token,
                'auto_generate_email' => $autoGenerateEmail,
                'status' => $status,
            ]);

            $credentials = [
                'email' => $email,
                'password' => $password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect('dashboard')->with('success', 'Authentication successful.');
            } else {
                return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
            }
        }
    }



    public function AdminLogOut()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function Delete($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }


    public function updateProfile($id)
    {
        $user = User::find($id);
        return view('admin.auth.updateprofile', ['users' => $user]);
    }

    public function saveUpdateProfile(Request $request, $id)
    {

$request->validate([
'membership_deposite'=> ['required', 'numeric', 'between:15,1000000'],
]);

        // return $request->input();
        $success = User::find($id)->update([
            'membership_deposite' => $request->membership_deposite,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->number,


        ]);
        if ($success) {
            return redirect()->back()->with('success', 'Form Updated Successfully');
        }
    }
}
