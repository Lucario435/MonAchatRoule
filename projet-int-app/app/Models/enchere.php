<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enchere extends Model
{
    protected $fillable = [
        'userid',
        'prix',
        'annonces_id',
        'mcontent',
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
