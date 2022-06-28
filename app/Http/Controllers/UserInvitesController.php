<?php

namespace App\Http\Controllers;

use App\laravel_messenger\InviteStatusManager;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class UserInvitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): Response|ResponseFactory
    {
        return inertia('Invites/index', [
            'invites' => auth()->user()->invites()->where('status', InviteStatusManager::WAITING)->with(['inviter', 'invited'])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Invites\StoreInviteRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $user): RedirectResponse
    {
        Invite::create([
            'inviter_id' => auth()->id(),
            'invited_id' => $user->id,
            'status' => InviteStatusManager::WAITING,
        ]);

        return redirect()->back();
    }

    /**
     * delete the given invite
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        Invite::where([
            'inviter_id' => auth()->id(),
            'invited_id' => $user->id,
        ])->delete();


        return redirect()->back();
    }
}

