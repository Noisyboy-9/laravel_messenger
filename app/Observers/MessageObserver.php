<?php

namespace App\Observers;

use App\laravel_messenger\LogPriorityManager;
use App\Models\Log;
use App\Models\Message;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     *
     * @param \App\Models\Message $message
     *
     * @return void
     */
    public function created(Message $message)
    {
        Log::create([
            'priority' => LogPriorityManager::INFO,
            'body' => "user with id: {$message->sender_id} has messaged {$message->receiver_id}"
        ]);
    }
}
