<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userrels extends Model
{
    use HasFactory;
    protected $fillable = [
        'reltype',
        'user_sender',
        'user_target'
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_sender');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'user_target');
    }
}
