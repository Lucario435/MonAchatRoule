<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    // Defaults values for each of our data
    protected $attributes = [
        'user_resolved_by'=>null,
    ];

    protected $fillable = [
        'user_sender',
        'user_target',
        'status',
        'mcontent',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_sender');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'user_target');
    }
    public function resolvedByUser()
    {
        return $this->belongsTo(User::class, 'user_resolved_by');
    }
    public function getStatusString(){
        if($this->status == 1)
            return "seen";
        if($this->status == 2)
            return "ok";

        return "unseen";
    }
}
