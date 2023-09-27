<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $fillable = [
        'userid',
        'mcontent',
        'clicked',
        'notificationLink',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
