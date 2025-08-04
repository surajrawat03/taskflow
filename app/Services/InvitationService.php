<?php

namespace App\Services;

use App\Models\User;
use App\Models\ProjectInvitation;
use App\Events\InvitationAccepted;

class InvitationService
{
    /**
     * Handle invitation acceptance logic
     *
     * @param ProjectInvitation $invitation
     * @return array
     */
    public function handleInvitationAcceptance(ProjectInvitation $invitation)
    {
        $user = User::where('email', $invitation->email)->first();
        
        if ($user) {
            // User exists - accept invitation directly
            return [
                'action' => 'accept_invitation',
                'data' => [
                    'email' => $invitation->email,
                    'invitation_id' => $invitation->id
                ],
                'message' => 'User exists - accept invitation directly'
            ];
        } else {
            // User doesn't exist - redirect to signup
            return [
                'action' => 'redirect_to_register',
                'data' => [
                    'email' => $invitation->email,
                    'invitation_id' => $invitation->id
                ],
                'message' => 'User does not exist, redirect to register'
            ];
        }
    }

    /**
     * Process invitation acceptance
     *
     * @param ProjectInvitation $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processInvitation(ProjectInvitation $invitation)
    {
        $result = $this->handleInvitationAcceptance($invitation);
        
        switch ($result['action']) {
            case 'accept_invitation':
                // Accept the invitation directly and show success message
                $this->acceptInvitation($invitation);
                return redirect()->route('dashboard')->with('success', 'Invitation accepted successfully!');
                
            case 'redirect_to_register':
            default:
                return redirect()->route('register')->withInput($result['data']);
        }
    }

    /**
     * Accept the invitation
     *
     * @param ProjectInvitation $invitation
     * @return void
     */
    private function acceptInvitation(ProjectInvitation $invitation)
    {
        // Update invitation status
        $invitation->update([
            'status' => 'accepted',
            'accepted_at' => now()
        ]);

        // Get the user by email
        $user = User::where('email', $invitation->email)->first();
        $project = $invitation->project;
        
        if ($project && $user && !$project->members()->where('user_id', $user->id)->exists()) {
            // Use attach() to create the relationship in project_members table
            $project->members()->attach($user->id, [
                'role' => $invitation->role ?? 'member'
            ]);
        }

        // Dispatch event for email notification
        if ($user) {
            event(new InvitationAccepted($user, $invitation));
        }
    }

    /**
     * Handle invitation acceptance after registration
     * This method should be called after user registers with invitation data
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function handlePostRegistrationInvitation(User $user)
    {
        // Check if there's invitation data in session
        if (session()->has('invitation_id')) {
            $invitationId = session('invitation_id');
            $invitation = ProjectInvitation::find($invitationId);
            
            if ($invitation && $invitation->email === $user->email && $invitation->status !== 'accepted') {
                // Accept the invitation
                $this->acceptInvitation($invitation);
                
                // Clear invitation data from session
                session()->forget(['invitation_id', 'email']);
                
                return redirect()->route('dashboard')->with('success', 'Registration successful and invitation accepted!');
            }
        }
        
        return null; // No invitation to process
    }
}