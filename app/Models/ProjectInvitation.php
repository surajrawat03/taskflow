<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
           'email',
           'role',
           'status',
           'accepted_at'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function inviter() {
        return $this->belongsTo(User::class, 'invited_by');
    }
}
