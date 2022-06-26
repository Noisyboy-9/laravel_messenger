<?php

namespace App\Providers;

use App\Models\Block;
use App\Models\FailedLoginAttempt;
use App\Models\Invite;
use App\Models\Like;
use App\Models\Message;
use App\Models\User;
use App\Observers\BlockObserver;
use App\Observers\FailedLoginAttemptObserver;
use App\Observers\InviteObserver;
use App\Observers\LikeObserver;
use App\Observers\MessageObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Block::observe(BlockObserver::class);
        FailedLoginAttempt::observe(FailedLoginAttemptObserver::class);
        Invite::observe(InviteObserver::class);
        Like::observe(LikeObserver::class);
        Message::observe(MessageObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
