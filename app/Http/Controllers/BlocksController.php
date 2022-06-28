<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class BlocksController extends Controller
{
    public function store(User $user): RedirectResponse
    {
        auth()->user()->blocks()->create([
            'blocked_id' => $user->id,
        ]);

        auth()->user()->connections()
            ->where('connected_id', $user->id)
            ->delete();

        $user->connections()
            ->where('connected_id', auth()->id())
            ->delete();

        $user->invites()
            ->where('inviter_id', auth()->id())
            ->delete();

        auth()->user()->invites()
            ->where('inviter_id', auth()->id())
            ->delete();


        return redirect()->back();
    }

    public function destroy(User $user): RedirectResponse
    {
        auth()->user()->blocks()->where('blocked_id', $user->id)->delete();
        return redirect()->back();
    }
}
