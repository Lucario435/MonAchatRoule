<?php

namespace App;

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
}
