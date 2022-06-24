<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class MessageInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $receiver = User::find($this->request->get('receiver_id'));

        if ($receiver == null) {
            return false;
        }

        return auth()->user()->isConnectedWith($receiver);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['receiver_id' => "string[]", "body" => "string[]"])] public function rules(): array
    {
        return [
            'receiver_id' => ["required", "exists:users,id"],
            "body" => ['required']
        ];
    }
}
