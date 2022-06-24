<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

class MessageLikesController extends Controller
{
    public function store(Message $message): RedirectResponse
    {
        Like::create([
            'liker_id' => auth()->id(),
            'message_id' => $message->id,
        ]);

        return redirect()->back();
    }

    public function destroy(Message $message): RedirectResponse
    {
        Like::where([
            'liker_id' => auth()->id(),
            'message_id' => $message->id,
        ])->delete();
        
        return redirect()->back();
    }
}
