<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'balance',
        'balance_work',
        'balance_frozen',
        'all_work',
        'all_pay',
        'all_send',
        'all_accept',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
