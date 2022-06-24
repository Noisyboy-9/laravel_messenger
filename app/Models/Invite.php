<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = ['inviter_id', 'invited_id', 'status'];


    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id', 'id');
    }

    public function invited(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_id', 'id');
    }
}
