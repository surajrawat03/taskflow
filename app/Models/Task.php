<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Task extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'created_by',
        'status',
        'assigned_to',
        'project_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    const PRIORITIES_LOW = 'low';
    const PRIORITIES_MEDIUM = 'medium';
    const PRIORITIES_HIGH = 'high';
    const STATUS_TODO = 'todo';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    public static function priorities()
    {
        return [
            self::PRIORITIES_LOW => 'Low',
            self::PRIORITIES_MEDIUM => 'Medium',
            self::PRIORITIES_HIGH => 'High',
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_TODO => 'To Do',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
