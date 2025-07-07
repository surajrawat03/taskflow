<?php

namespace App\Http\Livewire;

use App\Models\ProjectInvitation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Invitation extends Component
{
    use WithPagination;

    public $teamMembers = [];

    public $search = '';
    public  $perPage = 5;
    protected $listeners = ['invitationSent' => 'render'];

    // public function updatingSearch()
    // {
    //     $this->resetPage();
    // }

    public function render()
    {
        $user = Auth::user();
        $query = ProjectInvitation::query()
        ->with('project')
            ->where('invited_by', $user->id)
            ->when($this->search, function ($query) {
                return $query->where('email', 'like', '%' . $this->search . '%');
            });

        $invitations = $query->paginate($this->perPage);

        return view('livewire.invitation', compact('invitations'));
    }
}
