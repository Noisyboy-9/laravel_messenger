<?php

namespace App\Observers;

use App\Models\FailedLoginAttempt;
use Carbon\Carbon;

class FailedLoginAttemptObserver
{
    /**
     * Handle the FailedLoginAttempt "created" event.
     *
     * @param \App\Models\FailedLoginAttempt $failedLoginAttempt
     *
     * @return void
     */
    public function created(FailedLoginAttempt $failedLoginAttempt): void
    {
        //
    }

    /**
     * Handle the FailedLoginAttempt "updated" event.
     *
     * @param \App\Models\FailedLoginAttempt $failedLoginAttempt
     *
     * @return void
     */
    public function updated(FailedLoginAttempt $failedLoginAttempt): void
    {

        if ($failedLoginAttempt->penalty_end === null && $failedLoginAttempt->penalty_start === null && $failedLoginAttempt->failed_attempts_count >= 3) {
            $failedLoginAttempt->penalty_start = Carbon::now();
            $failedLoginAttempt->penalty_end = Carbon::now()->addDays(3);
            $failedLoginAttempt->save();
            return;
        }

        if ($failedLoginAttempt->penalty_start !== null || $failedLoginAttempt->penalty_end !== null) {

            if (Carbon::parse(!$failedLoginAttempt->penalty_end)->isFuture()) {
                $failedLoginAttempt->failed_attempts_count = 0;
                $failedLoginAttempt->penalty_start = null;
                $failedLoginAttempt->penalty_end = null;
                $failedLoginAttempt->save();
            }
        }
    }

    /**
     * Handle the FailedLoginAttempt "deleted" event.
     *
     * @param \App\Models\FailedLoginAttempt $failedLoginAttempt
     *
     * @return void
     */
    public function deleted(FailedLoginAttempt $failedLoginAttempt): void
    {
        //
    }

    /**
     * Handle the FailedLoginAttempt "restored" event.
     *
     * @param \App\Models\FailedLoginAttempt $failedLoginAttempt
     *
     * @return void
     */
    public function restored(FailedLoginAttempt $failedLoginAttempt): void
    {
        //
    }

    /**
     * Handle the FailedLoginAttempt "force deleted" event.
     *
     * @param \App\Models\FailedLoginAttempt $failedLoginAttempt
     *
     * @return void
     */
    public function forceDeleted(FailedLoginAttempt $failedLoginAttempt): void
    {
        //
    }
}
