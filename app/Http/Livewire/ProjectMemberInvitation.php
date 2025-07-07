<?php

namespace App\Http\Livewire;

use App\Models\ProjectInvitation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
use App\Mail\InvitationEmail;
use Illuminate\Support\Facades\Mail;

class ProjectMemberInvitation extends Component
{
    public $message;
    public $showModal = false;
    public $email = '';
    public $role = '';
    public $project_id;

    protected $listeners = ['openModal'];

    protected $messages = [
        'email.required' => 'Email address is required.',
        'email.unique' => 'This user is already part of the Project.',
        'email.email' => 'Please enter a valid email address.',
        'project_id.required' => 'Please select the project.',
    ];

    public function openModal()
    {
        $this->showModal = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->email = '';
        $this->role = 'member';
        $this->message = '';
        // $this->resetErrorBag();
    }

    public function sendInvitation()
    {
        $this->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('project_invitations')->where(function ($query) {
                    return $query->where('project_id', $this->project_id);
                }),
            ],
            'role' => 'required',
            'project_id' => 'required|integer',
            'message' => 'nullable|string|max:500',
        ], $this->messages);

        $user = Auth::user();
        $projectInvitations = new ProjectInvitation;
        $projectInvitations->email = $this->email;
        $projectInvitations->role = $this->role;
        $projectInvitations->project_id = $this->project_id;
        $projectInvitations->invited_by = $user->id;
        $projectInvitations->message = $this->message;
        $projectInvitations->save();

        Mail::to($this->email)->queue(new InvitationEmail($projectInvitations->id));

        // Generate a JWT for the authenticated user
        $token = JWTAuth::refresh(JWTAuth::getToken());

        // Queue a secure, HttpOnly cookie
        Cookie::queue(
            Cookie::make(
                'jwt',
                $token,
                JWTAuth::factory()->getTTL(), // minutes
                '/',                           // path
                null,                          // domain
                true,                          // secure
                true,                          // httpOnly
                false,                         // raw
                'Strict'                       // sameSite
            )
        );

        $this->closeModal();

        // Refresh the team members list
        $this->emit('invitationSent');
    }

    public function render()
    {
        $user = Auth::user();
        $projects = $user->projects;
        return view('livewire.project-member-invitation', compact('projects'));
    }
}
