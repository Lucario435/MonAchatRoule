<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class suiviannonce extends Model
{
    protected $fillable = [
        'userid',
        'publication_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function publication()
    {
        return $this->belongsTo(publication::class, 'publication_id');
    }
}
 