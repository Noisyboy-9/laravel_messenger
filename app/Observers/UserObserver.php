<?php

namespace App\Observers;

use App\laravel_messenger\LogPriorityManager;
use App\Models\Log;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function created(User $user): void
    {
        Log::create([
            'priority' => LogPriorityManager::INFO,
            'body' => "A new user with id: {$user->id} & username: {$user->username} & email: {$user->email} has been created"
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function updated(User $user): void
    {
        $newUserJson = $user->toJson();
        Log::create([
            'priority' => LogPriorityManager::INFO,
            'body' => "A user with id: {$user->id} has updated its data to be: ${newUserJson}"
        ]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function deleted(User $user): void
    {
        Log::create([
            'priority' => LogPriorityManager::WARNING,
            'body' => "A user with id:{$user->id} has deleted account"
        ]);
    }
}
