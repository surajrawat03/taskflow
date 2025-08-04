<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Events\InvitationAccepted;
use App\Listeners\AcceptedInvitation;
use App\Listeners\AddToProjectMember;
use App\Listeners\SendInvitationAcceptedEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegistered::class => [
            AcceptedInvitation::class,
            AddToProjectMember::class
        ],
        InvitationAccepted::class => [
            SendInvitationAcceptedEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
