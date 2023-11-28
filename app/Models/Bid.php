<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'user_id',
        'publication_id',
        'priceGiven',
        'bidStatus'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function publication()
    {
        return $this->belongsTo(publication::class, 'publication_id');
    }
}
