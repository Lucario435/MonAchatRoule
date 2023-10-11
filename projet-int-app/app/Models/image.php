<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        //Foreign key
        'publication_id',
        'url'
    ];
    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publication_id');
    }
}
