<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    protected $fillable = [
        'ventes_id',
        'userid',
        'user_target',
        'commentaire',
        'etoiles',
        'annonces_id',
    ];

    public function vente()
    {
        return $this->belongsTo(Vente::class, 'ventes_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'user_target');
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonces_id');
    }
}
