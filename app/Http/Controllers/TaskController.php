<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = auth()->user()->recentCreatedTasks;
        $projects = auth()->user()->projects;
       return view('projects.tasks', compact('tasks', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $statuses = $task::statuses();
        return view('projects.tasks.edit', compact('task', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|string',
            'priority' => 'required|string',
            'status' => 'required|string'
        ]);

        $data = $validator->validated();
        // Default to 0 if not present
        $data['is_completed'] = $request->has('is_completed') ? 1 : 0;

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json($validator->errors(), 422);
            }
            return response()->back()->withErrors($validator)->withInput();
        }

        $task->update($data);

        // Refresh jwt tocken.
        $token = JWTAuth::refresh(JWTAuth::getToken());

        if ($request->expectsJson()) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        }

        return redirect()->back()->with('success', 'Task updated successfully.')
            ->withCookie(cookie('jwt', $token, JWTAuth::factory()->getTTL(), '/', null, false, false));
        // return redirect()->route('tasks.edit', $task->id)
        //     ->with('success', 'Task updated successfully.')
        //     ->withCookie(cookie('jwt', $token, JWTAuth::factory()->getTTL())); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task  $tasl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            $messageType = 'success';
            $messageText = 'Task Deleted successfully';
        } catch (\Throwable $th) {
            $messageType = 'error';
            $messageText = 'Something went wrong';
        }

         // Refresh jwt tocken.
        $token = JWTAuth::refresh(JWTAuth::getToken());

        return redirect()->back()->with($messageType, $messageText)
            ->withCookie(cookie('jwt', $token, JWTAuth::factory()->getTTL(), '/', null, false, false));
    }
}
