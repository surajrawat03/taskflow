<?php

namespace App\Services;

// use App\Models\Project;
use App\Models\User;
// use Carbon\Carbon;

class DashboardService
{
    /**
     * Get all dashboard data for the given user.
     *
     * @param User $user
     * @return array
     */
    public function getDashboardData(User $user)
    {
        return [
            'total_projects' => $this->getTotalProjects($user),
            'completed_projects' => $this->getCompletedProjects($user),
            'total_tasks' => $this->getTotalTasks($user),
            'completed_tasks' => $this->getCompletedTasks($user),
            // 'upcomingDeadlines' => $this->getUpcomingDeadlines($userId),
            // 'tasksDueToday' => $this->getTasksDueToday($userId),
            // 'recentProjects' => $this->getRecentProjects($userId),
        ];
    }

    /**
     * Get total number of projects for the user.
     *
     * @param int $userId
     * @return int
     */
    private function getTotalProjects($user)
    {
        return $user->projects()->count();
    }

    /**
     * Get total number of tasks for the user.
     *
     * @param User $user
     * @return int
     */
    private function getTotalTasks(User $user)
    {
        return $user->tasks()->count();
    }

    /**
     * Get number of completed tasks for the user.
     *
     * @param User $user
     * @return int
     */
    private function getCompletedTasks($user)
    {
        return $user->tasks()->where('is_completed', true)->count();
    }

    /**
     * Get number of completed tasks for the user.
     *
     * @param User $user
     * @return int
     */
    private function getCompletedProjects($user)
    {
        return $user->projects()->where('status', 'completed')->count();
    }
    /**
     * Get number of tasks with upcoming deadlines (within 7 days).
     *
     * @param int $userId
     * @return int
     */
    private function getUpcomingDeadlines($userId)
    {
        return Task::whereHas('project', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereBetween('due_date', [Carbon::today(), Carbon::today()->addDays(7)])
            ->where('is_completed', false)
            ->count();
    }

    /**
     * Get tasks due today for the user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTasksDueToday($userId)
    {
        return Task::with('project')
            ->whereHas('project', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('due_date', Carbon::today())
            ->where('is_completed', false)
            ->get();
    }

    /**
     * Get recent projects with progress.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecentProjects($userId)
    {
        return Project::where('user_id', $userId)
            ->withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
                $query->where('is_completed', true);
            }])
            ->latest()
            ->take(5) // Limit to 5 recent projects
            ->get()
            ->map(function ($project) {
                $project->progress = $project->tasks_count > 0
                    ? round(($project->completed_tasks_count / $project->tasks_count) * 100)
                    : 0;
                return $project;
            });
    }
}