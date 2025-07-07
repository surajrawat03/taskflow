<?php

namespace App\Http\Controllers;

use App\Models\ProjectInvitation;
use App\Models\Team;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('invitations.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function show(Team $team)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Team $team)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Team $team)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Team  $team
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Team $team)
	{
		//
	}

	/**
	 * accept inviation.
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	public function accept(Request $request, $id, $email)
	{
		if (!$request->hasValidSignature()) {
			abort(403, 'Link expired or invalid');
		}

		$projectInvitation = ProjectInvitation::findOrFail($request->id);

		// Flash the invitation email to the session
		return redirect()->route('register')->withInput(['email' => $projectInvitation->email, 'invitation_id' => $projectInvitation->id]);
	}
}
