<?php

namespace App\Mail;

use App\Models\ProjectInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invitationId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invitationId)
    {
        $this->invitationId = $invitationId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invitation = ProjectInvitation::findOrFail($this->invitationId);
        $inviter = $invitation->inviter;
        $project = $invitation->project;
        return $this->subject('You are invited!')
        ->view('emails.invitation', compact('invitation', 'inviter', 'project'));
    }
}
