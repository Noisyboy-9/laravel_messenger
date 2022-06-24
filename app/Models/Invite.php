<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = ['inviter_id', 'invited_id', 'status'];


    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id', 'id');
    }

    public function invited()
    {
        return $this->belongsTo(User::class, 'invited_id', 'id');
    }
}
