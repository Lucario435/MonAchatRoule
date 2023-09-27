<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vente extends Model
{
    protected $fillable = [
        'userid',
        'seller_id',
        'annonces_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonces_id');
    }
}
