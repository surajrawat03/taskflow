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

    public $projectInvitation;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ProjectInvitation $projectInvitation, User $user)
    {
        $this->projectInvitation = $projectInvitation;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invitation = $this->projectInvitation;
        $acceptedUser = $this->user;
        $project = $invitation->project;
        return $this->subject('Invitation Accepted - ' . $project->name)
            ->view('emails.accepted-invitation', compact('invitation', 'acceptedUser', 'project'));
    }
} 