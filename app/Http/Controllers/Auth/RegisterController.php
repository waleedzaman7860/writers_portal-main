<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function ajaxregister(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        // $this->guard()->login($user);
        if ($user) {
            return response()->json(['message' => $user]);
            // 'Your Request is Pending. This will take Not more than 24 Hours You will be informed via email'
        }

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return response('Success');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
        'deposite_slip' => 'required|file|mimes:doc,png,docx,pdf|max:204800',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'user_referral_code' => ['required'],
            'membership_deposite' => ['required', 'numeric', 'between:15,1000000'], // Adjust the upper limit as needed

            'referral_code' => ['nullable'],
            'referral_earning' => ['nullable'],

            'number' => ['required'],
            'joining_bonus' => ['required'],


            'bep_wallet_address' => ['required'],
            'admin_wallet_address' => ['required'],


        ], [
            'membership_deposite' => 'You must Need To Deposite minimum 15 USDT',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $referral_code = $data['referral_code'];
        if ($referral_code) {
            $refexists = User::where('writer_referal_code', '=', $referral_code)->exists();
            if ($refexists) {
                $refexists = User::where('writer_referal_code', '=', $referral_code)->first();
                $referral_id = $refexists->id;


                $addbonus = $refexists->referral_earning;
                $v =  '0.50';
                $array = array($addbonus, $v);
                $arraysum = array_sum($array);

                $success = User::where('writer_referal_code', '=', $referral_code)->first()->update([
                    'referral_earning' =>   $arraysum,

                ]);



                $depositeSlipPath = null;
                if (isset($data['deposite_slip']) && $data['deposite_slip'] instanceof UploadedFile) {
                    $depositeSlipPath = $data['deposite_slip']->store('initial_deposite_slips', 'public');
                }

                $success = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'auto_generate_email' => $data['auto_generate_email'] ?? '',
                    'password' => $data['password'] ?? '',
                    'writer_referal_code' => $data['user_referral_code'],
                    'joining_bonus' => $data['joining_bonus'],
                    'phone' => $data['number'],
                    'bep_wallet_address' => $data['bep_wallet_address'],
                    'admin_wallet_address' => $data['admin_wallet_address'],
                    'deposite_slip' => $depositeSlipPath,
                    'membership_deposite' => $data['membership_deposite'],
                    'status' => $data['status'] ?? 'pending',
                ]);

                $g = User::latest()->first();
                $gUId = $g->id;

                $success = Referral::create([

                    'user_id' => $gUId,
                    'referral_id' => $referral_id,
                    'user_profit' => '0',
                    'referral_profit' => '0',

                ]);


                if ($success) {
                    return redirect('/')->with('success', 'Your Request is Pending.
                                                            This will take Not more
                                                            than 24 Hours You will
                                                            be informed via email');
                }
            } else {
                return redirect('/')->with('fail', $referral_code . ' Referral code is not exist');
                return response()->json(['message' => 'referral code is not exist']);
            }
        } else {





            $depositeSlipPath = null;
            if (isset($data['deposite_slip']) && $data['deposite_slip'] instanceof UploadedFile) {
                $depositeSlipPath = $data['deposite_slip']->store('initial_deposite_slips', 'public');
            }

            $success = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'auto_generate_email' => $data['auto_generate_email'] ?? '',
                'password' => $data['password'] ?? '',
                'writer_referal_code' => $data['user_referral_code'],
                'joining_bonus' => $data['joining_bonus'],
                'phone' => $data['number'],
                'bep_wallet_address' => $data['bep_wallet_address'],
                'admin_wallet_address' => $data['admin_wallet_address'],
                'deposite_slip' => $depositeSlipPath,
                'membership_deposite' => $data['membership_deposite'],
                'joining_bonus' => $data['joining_bonus'] ?? '',
                'status' => $data['status'] ?? 'pending',

            ]);




            if ($success) {
                return redirect('/')->with('success', 'Your Request is Pending.
                                                                This will take Not more
                                                                than 24 Hours You will
                                                                be informed via email');
            }
        }
    }
}
