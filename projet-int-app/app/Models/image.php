<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $fillable = [
        'annonces_id',
        'imagepath',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonces_id');
    }
}
