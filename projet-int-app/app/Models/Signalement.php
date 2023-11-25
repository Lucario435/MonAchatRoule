<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    protected $fillable = [
        'user_sender',
        'user_target',
        'status',
        'mcontent',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_sender');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'user_target');
    }
    public function getStatusString(){
        if($this->status == 1)
            return "seen";
        if($this->status == 2)
            return "ok";

        return "unseen";
    }
}
