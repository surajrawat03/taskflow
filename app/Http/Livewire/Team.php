<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Team extends Component
{
    public $sortField;

    public $sortDirection;

    public $teamMembers = [];

    protected $listeners = ['openInvitationModal', 'invitationSent' => 'render'];

    public function openInvitationModal()
    {
        $this->emit('openModal');
    }

    public function render()
    {
        return view('livewire.team');
    }
}
