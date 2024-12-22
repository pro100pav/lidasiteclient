<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassicPartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'bot_id',
        'user_id',
        'refer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function nastavnik()
    {
        return $this->belongsTo(User::class, 'refer_id');
    }

    public function partner()
    {
        return $this->hasMany(ClassicPartner::class, 'refer_id', 'user_id')->where('bot_id', $this->bot_id);
    }

    public function childrenPartners()
    {
        return $this->hasMany(ClassicPartner::class, 'refer_id', 'user_id')->where('bot_id', $this->bot_id)->with('partner');
    }

    public function parent()
    {
        return $this->belongsTo(ClassicPartner::class, 'refer_id', 'user_id')->where('bot_id', $this->bot_id);
    }

    public function getParents()
    {
        
        $parents = collect([]);
        $parent = $this->parent;

        $i = 0;
        while(!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
            $i++;
        }

        return $parents;
    }
    
}
