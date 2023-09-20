<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'hidden',
        'fixedPrice',
        'expirationOfBid',
        'postalCode'
    ];

    // Foreign Key User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
