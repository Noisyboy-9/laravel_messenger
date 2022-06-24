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

        return redirect()->back();
    }

    public function destroy(User $user): RedirectResponse
    {
        $block = auth()->user()->blocks()->where('blocked_id', $user->id)->get();

        if ($block) {
            $block->delete();
        }

        return redirect()->back();
    }
}
