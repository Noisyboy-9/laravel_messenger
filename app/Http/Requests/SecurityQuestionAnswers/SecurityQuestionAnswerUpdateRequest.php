<?php

namespace App\Http\Requests\SecurityQuestionAnswers;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class SecurityQuestionAnswerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $answer = $this->route->parameter('answer');
        return $answer->user_id == $this->user()->id;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['question_id' => "string[]", 'answer' => "string[]"])] public function rules(): array
    {
        return [
            'answer' => ['required', 'min:4']
        ];
    }
}
