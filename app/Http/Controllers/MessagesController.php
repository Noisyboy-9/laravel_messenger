<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\MessageInsertRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class MessagesController extends Controller
{
    public function index(User $user): Response|ResponseFactory
    {
        $messages = Message::where(['sender_id' => $user->id, 'receiver_id' => auth()->id()])->orWhere(['sender_id' => auth()->id(), 'receiver_id' => $user->id])->with('receiver', 'sender')->orderBy('created_at')->get();

        return inertia("Message/show", [
            'messages' => $messages->toArray(),
            'auth' => auth()->user(),
            'chattingWithUser' => $user
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
