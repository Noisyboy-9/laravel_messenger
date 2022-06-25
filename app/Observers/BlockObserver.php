<?php

namespace App\Observers;

use App\laravel_messenger\LogPriorityManager;
use App\Models\Block;
use App\Models\Log;

class BlockObserver
{
    /**
     * Handle the Block "created" event.
     *
     * @param \App\Models\Block $block
     *
     * @return void
     */
    public function created(Block $block): void
    {
        Log::create([
            'priority' => LogPriorityManager::WARNING,
            'body' => "user with id:{$block->blocker_id} has blocked {$block->blocked_id}"
        ]);
    }

    /**
     * Handle the Block "deleted" event.
     *
     * @param \App\Models\Block $block
     *
     * @return void
     */
    public function deleted(Block $block): void
    {
        Log::create([
            'priority' => LogPriorityManager::WARNING,
            'body' => "user with id:{$block->blocker_id} has unblocked {$block->blocked_id}"
        ]);
    }

}
