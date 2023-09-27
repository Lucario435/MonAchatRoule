<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'phone',
        'email',
        'emailnotificationsenabled',
        'accstatus',
        'displayname',
        'userimage',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAnnonces()
    {
        return $this->hasMany(Annonce::class, 'userid');
    }
    public function getMessages()
    {
        return $this->hasMany(chatmessages::class, 'userid');
    }

    //https://stackoverflow.com/questions/46841159/laravel-hasmany-and-belongsto-parameters
    /*
To simplify the syntax, think of the return $this->hasMany('App\Comment', 'foreign_key', 'local_key'); parameters as:

The model you want to link to
The column of the foreign table (the table you are linking to) that links back to the id column of the current table (unless you are specifying the third parameter, in which case it will use that)
The column of the current table that should be used - i.e if you don't want the foreign key of the other table to link to the id column of the current table
    */
}
