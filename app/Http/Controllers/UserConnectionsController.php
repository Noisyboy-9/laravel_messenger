<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\ResponseFactory;

class UserConnectionsController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $connections = auth()->user()->connections()->with(['connecter', 'connected'])->get();
        return inertia('Connections/index', [
            'connections' => $connections,
        ]);

    }
}
