<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'phone_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class, 'invited_id', 'id');
    }

    public function inviteds(): HasMany
    {
        return $this->hasMany(Invite::class, "inviter_id", 'id');
    }

    public function searchableUsing()
    {
        return app(EngineManager::class)->engine('meilisearch');
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class, "blocker_id", "id");
    }

    public function isConnectedWith(User $user): bool
    {
        return $this->connections()->where('connected_id', $user->id)->exists();
    }

    public function connections(): HasMany
    {
        return $this->hasMany(Connection::class, 'connecter_id', 'id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, "sender_id", "id");
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, "receiver_id", "id");
    }

    public function incrementFailedLoginAttemptsCount(): void
    {
        $failedLoginAttempt = $this->failedLoginAttempts()->first();
        $failedLoginAttempt->increment('failed_attempts_count');
        $failedLoginAttempt->save();
    }

    public function failedLoginAttempts(): HasOne
    {
        return $this->hasOne(FailedLoginAttempt::class, 'user_id', 'id');
    }

    public function isInLoginPenalty(): bool
    {
        $failedLoginAttempts = $this->failedLoginAttempts()->first();

        if ($failedLoginAttempts->penalty_start->isEmpty() || $failedLoginAttempts->penalty_end->isEmpty()) return false;

        return Carbon::parse($failedLoginAttempts->penalty_start)->isPast()
            && Carbon::parse($failedLoginAttempts->penalty_end)->isFuture();
    }

}



