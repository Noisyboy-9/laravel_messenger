<?php

namespace App\Observers;

use App\laravel_messenger\InviteStatusManager;
use App\laravel_messenger\LogPriorityManager;
use App\Models\Invite;
use App\Models\Log;

class InviteObserver
{
    /**
     * Handle the Invite "created" event.
     *
     * @param \App\Models\Invite $invite
     *
     * @return void
     */
    public function created(Invite $invite): void
    {
        Log::create([
            'priority' => LogPriorityManager::INFO,
            'body' => "user with id:{$invite->inviter_id} has invited user with id: {$invite->invited_id}"
        ]);
    }

    public function deleted(Invite $invite): void
    {
        Log::create([
            'priority' => LogPriorityManager::INFO,
            'body' => "user with id:{$invite->inviter_id} has deleted its invite on user with id: {$invite->invited_id}"
        ]);
    }

    public function updated(Invite $invite): void
    {
        if ($invite->status === InviteStatusManager::ACCEPTED) {
            Log::create([
                'priority' => LogPriorityManager::INFO,
                'body' => "user with id:{$invite->invited_id} has accepted invite from user with id: {$invite->inviter_id}"
            ]);
        } else if ($invite->status === InviteStatusManager::REJECTED) {
            Log::create([
                'priority' => LogPriorityManager::INFO,
                'body' => "user with id:{$invite->invited_id} has rejected invite from user with id: {$invite->inviter_id}"
            ]);
        }
    }
}
