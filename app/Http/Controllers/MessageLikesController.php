<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Message;

class MessageLikesController extends Controller
{
    public function store(Message $message)
    {
        Like::create([
            'liker_id' => auth()->id(),
            'message_id' => $message->id,
        ]);

        return redirect()->back();
    }

    public function destroy(Message $message)
    {
        $like = Like::find([
            'liker_id' => auth()->user(),
            'message_id' => $message->id,
        ]);

        $like->delete();
    }
}
