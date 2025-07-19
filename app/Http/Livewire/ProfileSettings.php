<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileSettings extends Component
{
    public $name;
    public $email;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ];
    }

    public function updateProfile()
    {
        $this->validate();
        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();
        session()->flash('success', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile-settings');
    }
}
