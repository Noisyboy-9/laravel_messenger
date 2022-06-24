<?php

namespace App\Http\Controllers;

use App\laravel_messenger\InviteStatusManager;

class UserInvitedController extends Controller
{
    public function index()
    {
        return inertia('Invited/index', [
            'inviteds' => auth()->user()->inviteds()->where('status', InviteStatusManager::WAITING)->with(['inviter', 'invited'])->get()
        ]);
    }
}
