<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        //Publication info
        'title',
        'description',
        'type',
        'expirationOfBid',
        'postalCode',
        'publicationStatus',
        'hidden',

        //Foreign key
        'user_id',

        //Car info
        'fixedPrice',
        'kilometer',
        //MISSING carburant and year
        'year',
        'fuelType',
        'bodyType',
        'transmission',
        'brand',
        'color'
    ];

    // Foreign Key User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images(){
        return $this->hasMany(Image::class,"publication_id");
    }

    public function brands(){
        return DB::table('publications')->pluck('brand');
    }

}
