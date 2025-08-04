<?php

namespace App\Http\Controllers;

use App\Models\ProjectInvitation;
use App\Models\Team;
use App\Models\User;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    protected $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

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
	 * Accept invitation.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @param string $email
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function accept(Request $request, $id, $email)
	{
		if (!$request->hasValidSignature()) {
			abort(403, 'Link expired or invalid');
		}

		$projectInvitation = ProjectInvitation::findOrFail($id);

		// Use the service to handle invitation acceptance
		return $this->invitationService->processInvitation($projectInvitation);
	}
}
