<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Project;
use App\Models\Task;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Return the user's unique identifier (e.g., ID)
    public function getJWTIdentifier() {
        return $this->getKey(); // Usually $this->id
    }

    // Return custom claims (extra data to include in the token)
    public function getJWTCustomClaims() {
        return []; // You can add roles, permissions, etc.
    }

    // public function projects()
    // {
    //     return $this->hasMany(Project::class)->withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
    //             $query->where('is_completed', true);
    //         }]);
    // }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_members')
                ->withPivot('role')
                ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to', 'id');
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by', 'id');
    }

    public function recentCreatedTasks()
    {
        return $this->hasMany(Task::class, 'created_by', 'id')
                ->with('projects')
                ->latest()  // ORDER BY created_at DESC
                ->limit(5); // LIMIT 5
    }

    public function sentInvitations() {
        return $this->hasMany(ProjectInvitation::class, 'invited_by');
    }

}
