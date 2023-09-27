<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'seen',
        'mcontent',
        'annonces_id',
        'user_sender',
        'user_receiver',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonces_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_sender');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_receiver');
    }
}
