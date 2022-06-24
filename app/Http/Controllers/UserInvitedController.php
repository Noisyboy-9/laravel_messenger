<?php

namespace App\Http\Controllers;

class UserInvitedController extends Controller
{
    public function index()
    {
        return inertia('Invited/index', [
            'invited' => auth()->user()->invited
        ]);
    }
}
