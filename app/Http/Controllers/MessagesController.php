<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageInsertRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class MessagesController extends Controller
{
    public function index(User $user): Response|ResponseFactory
    {
        $sentMessages = auth()->user()->sentMessages()->where('receiver_id', $user->id)->get();
        $receivedMessages = auth()->user()->receivedMessages()->where('sender_id', $user->id)->get();

        $messages = $sentMessages->merge($receivedMessages);
        $messages->sortByDesc('created_at');

        return inertia("Message/show", [
            'messages' => $messages,
            'auth' => auth()->user(),
            'user' => $user
        ]);
    }

    public function store(MessageInsertRequest $request): RedirectResponse
    {
        auth()->user()->sentMessages()->create([
            'receiver_id' => $request->get('receiver_id'),
            'body' => $request->get('body')
        ]);

        return redirect()->back();
    }

    public function destroy(Message $message): RedirectResponse
    {
        if ($message->sender_id = auth()->id()) {
            $message->delete();
        }

        return redirect()->back();
    }
}
