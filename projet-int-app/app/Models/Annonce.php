<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $table = 'annonces';
    protected $fillable = [
        'titre',
        'desc',
        'prixFixe',
        'date_finencheres',
        'codepostale',
        'annoncestatus',
        'km',
        'corps',
        'transmission',
        'vehiclecolor',
        'userid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
        /* REPONSE DE CHATGPT SUR LES PARAMETRES DE BELONGSTO00
The second parameter is the name of the foreign key column in the current model's table. This is the column that holds the ID referencing the related model.
Example: 'user_id'
The third parameter (optional) is the name of the primary key column in the related model's table. If not specified, Laravel assumes that the primary key column in the related model's table is named 'id'. You would only specify this parameter if the primary key column has a different name.
Example: 'id'*/
    }
}
