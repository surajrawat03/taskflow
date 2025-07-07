<?php

namespace App\Mail;

use App\Models\ProjectInvitation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptedInvitationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invitation;
    public $newMember;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ProjectInvitation $invitation, User $newMember)
    {
        $this->invitation = $invitation;
        $this->newMember = $newMember;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $inviter = $this->invitation->inviter;
        $project = $this->invitation->project;
        return $this->subject('Your Invitation Was Accepted!')
            ->view('emails.accepted-invitation', [
                'invitation' => $this->invitation,
                'inviter' => $inviter,
                'project' => $project,
                'newMember' => $this->newMember,
            ]);
    }
} 