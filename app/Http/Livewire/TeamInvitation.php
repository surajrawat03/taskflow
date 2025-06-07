<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeamInvitation extends Component
{
    public $message;

    public $showModal = false;

    protected $listeners = ['openModal'];

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
        $this->resetErrorBag();
    }

    public function render()
    {
        
        return view('livewire.team-invitation');
    }
}
