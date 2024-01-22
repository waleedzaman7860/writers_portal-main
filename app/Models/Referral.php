<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_id',

    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }






    public function userRelation()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referralRelation()
    {
        return $this->belongsTo(User::class, 'referral_id');
    }


}
