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
        'id_telegram',
        'name',
        'username',
        'phone',
        'email',
        'isadmin',
        'work',
        'code_auth',
        'blocked',
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
    ];
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    
    public function chats()
    {
        return $this->hasMany(Bot\ChatUser::class, 'user_id');
    }
    public function billing()
    {
        return $this->hasMany(Billing::class);
    }
    public function balance()
    {
        return $this->hasOne(UserBalance::class);
    }
    public function partner()
    {
        return $this->hasMany(ClassicPartner::class);
    }
    public function breadcrumbspartner($botId)
    {
        return $this->partner->where('bot_id',$botId)->first()->getParents();
    }
    
    public function notif()
    {
        return $this->hasMany(Bot\Notice::class);
    }
    public function bots()
    {
        return $this->hasMany(Bot\UserBot::class);
    }
    
    public function botStep()
    {
        return $this->hasMany(Bot\BotStep::class);
    }
    
    
    public function adds()
    {
        return $this->hasMany(Bot\AddsPost::class);
    }
    
    public function isstepBot($bot)
    {
        if($this->botStep->where('bot_id', $bot)->count() == 0){
            Bot\BotStep::create([
                'user_id' => $this->id,
                'bot_id' => $bot,
            ]);
            return 0;
        }else{
            foreach($this->botStep as $step){
                if($step->bot_id == $bot){
                    return $step->step;
                }
            }
        }
        
        return 0;
    }
    public function plusstepBot($bot,  $number)
    {
        foreach($this->botStep as $step){
            if($step->bot_id == $bot){
                $step->step = $number;
                $step->save();
                return $number;
            }
        }
        return 0;
    }
    public function refBot($botres)
    {
        foreach($this->bots as $bot){
            
            foreach($bot->user->breadcrumbspartner($bot->bot_id) as $item){
                if($item->user->bots->where('bot_id', $botres)->first()){
                    return $item->user->id;
                }
            }
        }
        return 2;
    }

    
}
