<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;
class Message extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}