<?php

namespace App\Http\Controllers;

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
            'invites' => auth()->user()->invites()->where('accepted', 'NULL')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Invites\StoreInviteRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $invited): RedirectResponse
    {
        Invite::create([
            'inviter_id' => auth()->id(),
            'invited_id' => $invited->id,
            'accepted' => false,
        ]);

        return redirect()->back();
    }
}
