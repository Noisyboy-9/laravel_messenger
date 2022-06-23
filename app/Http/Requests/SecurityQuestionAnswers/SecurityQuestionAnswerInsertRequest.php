<?php

namespace App\Http\Requests\SecurityQuestionAnswers;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class SecurityQuestionAnswerInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return request()->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['question_id' => "string[]", 'answer' => "string[]"])] public function rules(): array
    {
        return [
            'question_id' => ["required", "exists:security_questions,id"],
            'answer' => ['required', 'min:4']
        ];
    }
}
