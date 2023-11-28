<?php

namespace App\Models;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Model;

class Chatmessage extends Model
{
    protected $fillable = [
        'seen',
        'mcontent',
        'user_sender',
        'user_receiver',
        "publication_id",
        "hidden",
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
