<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 */
class SecurityQuestion extends Model
{
    use HasFactory;

    protected $fillable = ["title"];

    public function answers()
    {
        return $this->hasMany(SecurityQuestionAnswer::class, "question_id", "id");
    }
}
