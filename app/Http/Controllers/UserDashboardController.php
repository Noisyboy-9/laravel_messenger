<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;

class UserDashboardController extends Controller
{
    public function show(User $user): Response|ResponseFactory
    {
        return inertia('Dashboard/show', [
            "viewingUser" => $user,
            "auth" => auth()->user(),
        ]);
    }
}
