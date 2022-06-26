<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedLoginAttempt extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = "failed_login_attempts";

    protected $fillable = ['user_id', 'failed_attempts_count', 'penalty_start', 'penalty_end'];

}
