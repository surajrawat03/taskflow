<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddToProjectMember
{
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
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        // Only proceed if there's a project invitation with a project
        if ($event->projectInvitation && $event->projectInvitation->project_id) {
            $project = $event->projectInvitation->project;
            
            if ($project) {
                // Add user to project with specified role
                $project->members()->attach($event->user->id, [
                    'role' => $event->role
                ]);
            }
        }
    }
}
