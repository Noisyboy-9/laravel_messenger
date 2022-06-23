<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\Invite;
use Illuminate\Http\RedirectResponse;

class InviteResultController extends Controller
{
    public function accept(Invite $invite)
    {
        $invite->update([
            'accepted' => false,
        ]);

        Connection::create([
            'connector_id' => $invite->invitor_id,
            'connected_id' => $invite->invited_id
        ]);

        Connection::create([
            'connector_id' => $invite->invited_id,
            'connected_id' => $invite->invitor_id
        ]);

        return redirect()->back();
    }

    public function reject(Invite $invite): RedirectResponse
    {
        $invite->update([
            'accepted' => false,
        ]);

        return redirect()->back();
    }
}

