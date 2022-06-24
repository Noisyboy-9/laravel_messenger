<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserDashboardController extends Controller
{
    public function show(User $user)
    {
        return inertia('Dashboard/show', [
            "viewingUser" => $user,
            "auth" => auth()->user()
        ]);
    }
}
