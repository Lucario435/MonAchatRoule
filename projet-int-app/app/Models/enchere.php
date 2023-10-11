<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enchere extends Model
{
    protected $fillable = [
        'userid',
        'prix',
        'publication_id',
        'mcontent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function annonce()
    {
        return $this->belongsTo(Publication::class, 'publication_id');
    }
}
