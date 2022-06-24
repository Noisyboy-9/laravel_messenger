<?php

namespace App\Http\Controllers;

use App\laravel_messenger\InviteStatusManager;
use App\Models\Connection;
use App\Models\Invite;
use Illuminate\Http\RedirectResponse;

class InviteResultController extends Controller
{
    public function accept(Invite $invite): RedirectResponse
    {
        $invite->update([
            'status' => InviteStatusManager::ACCEPTED,
        ]);


        Connection::create([
            'connecter_id' => $invite->inviter_id,
            'connected_id' => $invite->invited_id
        ]);

        Connection::create([
            'connecter_id' => $invite->invited_id,
            'connected_id' => $invite->inviter_id
        ]);

        return redirect()->back();
    }

    public function reject(Invite $invite): RedirectResponse
    {
        $invite->update([
            'status' => InviteStatusManager::REJECTED,
        ]);

        return redirect()->back();
    }
}

