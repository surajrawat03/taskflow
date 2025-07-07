<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\ProjectInvitation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\AcceptedInvitationEmail;
use Illuminate\Support\Facades\Mail;

class AcceptedInvitation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if ($event->projectInvitation) {
            $event->projectInvitation->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);
            $inviter = $event->projectInvitation->inviter;
            if ($inviter && $inviter->email) {
                Mail::to($inviter->email)->queue(new AcceptedInvitationEmail($event->projectInvitation, $event->user));
            }
        }
    }
}
