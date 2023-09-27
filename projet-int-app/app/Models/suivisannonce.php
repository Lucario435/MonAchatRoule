<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suiviannonce extends Model
{
    protected $fillable = [
        'userid',
        'annonces_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonces_id');
    }
}
