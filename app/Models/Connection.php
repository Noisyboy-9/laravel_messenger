<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Connection extends Model
{
    use HasFactory;

    protected $fillable = ['connecter_id', 'connected_id'];

    public function connecter(): BelongsTo
    {
        return $this->belongsTo(User::class, "connecter_id", "id");
    }


    public function connected(): BelongsTo
    {
        return $this->belongsTo(User::class, "connected_id", "id");
    }
}
