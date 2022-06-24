<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use function inertia;

class SearchController extends Controller
{
    public function search(): Response|ResponseFactory
    {
        $users = User::search(request()->query('q'))->get();

        return inertia('Dashboard', [
            'title' => 'dashboard',
            'users' => $users
        ]);
    }
}
