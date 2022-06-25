<?php

namespace App\Observers;

use App\laravel_messenger\LogPriorityManager;
use App\Models\Like;
use App\Models\Log;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     *
     * @param \App\Models\Like $like
     *
     * @return void
     */
    public function created(Like $like)
    {
        Log::create([
            'priority' => LogPriorityManager::INFO,
            'body' => "message with id: {$like->message_id} has been like by {$like->liker_id}"
        ]);
    }

    /**
     * Handle the Like "deleted" event.
     *
     * @param \App\Models\Like $like
     *
     * @return void
     */
    public function deleted(Like $like)
    {
        Log::create([
            'priority' => LogPriorityManager::INFO,
            'body' => "message with id: {$like->message_id} has been unliked by {$like->liker_id}"
        ]);
    }
}
