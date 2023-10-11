<?php

namespace App;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Model;

class vente extends Model
{
    protected $fillable = [
        'userid',
        'seller_id',
        'publication_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publication_id');
    }
}
