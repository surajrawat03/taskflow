<?php

namespace App\Listeners;

use App\Events\InvitationAccepted;
use App\Mail\AcceptedInvitationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvitationAcceptedEmail implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param  \App\Events\InvitationAccepted  $event
     * @return void
     */
    public function handle(InvitationAccepted $event)
    {
        $invitation = $event->projectInvitation;
        $acceptedUser = $event->user;
        $inviter = $invitation->inviter;

        // Send email to the person who sent the invitation
        if ($inviter && $inviter->email) {
            Mail::to($inviter->email)->queue(new AcceptedInvitationEmail($invitation, $acceptedUser));
        }
    }
} 