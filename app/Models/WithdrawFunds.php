<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawFunds extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bep_wallet_address',
        'withdraw_amount',
        'status',

    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }


}
