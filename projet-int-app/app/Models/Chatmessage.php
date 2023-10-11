<?php

namespace App;

use App\Models\Publication;
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

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publication_id');
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
