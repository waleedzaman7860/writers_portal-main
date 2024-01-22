<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'auto_generate_email',
        'phone',
        'bep_wallet_address',
        'admin_wallet_address',
        'deposite_slip',
        'membership_deposite',
        'joining_bonus',
        'status',
        'writer_referal_code',
        'referral_earning',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function Article()
    {
        return $this->hasMany(Article::class);
    }

    public function Withdraws()
    {
        return $this->hasMany(WithdrawFunds::class);
    }

    // public function Referral()
    // {
    //     return $this->hasMany(Referral::class,'user_id', 'referral_id','id');
    // }

    // public function userReferral()
    // {
    //     return $this->hasMany(Referral::class,  'id','user_id', 'referral_id');
    // }

}
