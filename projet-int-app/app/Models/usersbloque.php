<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usersbloque extends Model
{
    protected $fillable = [
        'userid',
        'user_target',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function blockedUser()
    {
        return $this->belongsTo(User::class, 'user_target');
    }
}
