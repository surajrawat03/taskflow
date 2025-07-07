<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = auth()->user()->projects;
        $recentTasks = auth()->user()->recentCreatedTasks;
        return view('projects.index', compact('projects', 'recentTasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Project::statuses();
        return view('projects.create', ['statuses' => $statuses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json($validator->errors(), 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $project = Project::create($validator->validated());

        // Add the creator as a project member (role: owner)
        $project->members()->attach(auth()->id(), ['role' => 'owner']);

        // Generate a JWT for the authenticated user
        $token = JWTAuth::refresh(JWTAuth::getToken());

        if ($request->expectsJson()) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ]);
        }

        return redirect()->route('projects.index')->withCookie(
            cookie('jwt', $token, JWTAuth::factory()->getTTL())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $statuses = Project::statuses();
        return view('projects.edit', compact('project', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json($validator->errors(), 422);
            }
            return response()->back()->withErrors($validator)->withInput();
        }

        $project->update($validator->validated());

        // Refresh jwt tocken.
        $token = JWTAuth::refresh(JWTAuth::getToken());

        if ($request->expectsJson()) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        }

        return redirect()->route('projects.show', $project->id)->withCookie(
            cookie('jwt', $token, JWTAuth::factory()->getTTL())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            $msg = 'Project deleted successfully.';
            $msgType = 'success';
        } catch (\Throwable $th) {
            $msg = 'Something went wrong.';
            $msgType = 'error';
        }

        // Refresh jwt tocken.
        $token = JWTAuth::refresh(JWTAuth::getToken());

        return redirect()->back()->with($msgType, $msg)->withCookie(cookie('jwt', $token, JWTAuth::factory()->getTTL()));
    }
}
