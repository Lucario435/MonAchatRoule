<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $fillable = [
        'userid',
        'mcontent',
        'clicked',
        'notificationLink',
    ];

    public function title(){
        $decoded = json_decode($this->attributes["mcontent"]);
        return $decoded->title;
    }
    public function msg(){
        $decoded = json_decode($this->attributes["mcontent"]);
        return $decoded->msg;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
