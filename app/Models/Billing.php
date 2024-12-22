<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'balance_add',
        'balance_off',
        'description',
        'type',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function typeOperation()
    {
        if($this->type == 0){
            return 'Покупка актива';
        }
        if($this->type == 1){
            return 'Активация ключа';
        }
        if($this->type == 2){
            return 'Передача ключа';
        }
        if($this->type == 3){
            return 'Отправлен подарок';
        }
        if($this->type == 4){
            return 'Активация пакета';
        }
        if($this->type == 5){
            return 'Повышение пакета';
        }
        if($this->type == 6){
            return 'Начисление бонуса';
        }
    }
}
