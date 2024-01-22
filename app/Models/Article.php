<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [

        'user_id',
        'article',
        'article_file',
        'article_type',
        'status',
        'article_earning',

    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
