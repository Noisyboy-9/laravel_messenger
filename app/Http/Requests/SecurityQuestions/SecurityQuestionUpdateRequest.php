<?php

namespace App\Http\Requests\SecurityQuestions;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class SecurityQuestionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return request()->user()->email == "sina.shariati@yahoo.com";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(["title" => "string"])] public function rules(): array
    {
        return [
            "title" => ["required", "unique:security_questions,title"]
        ];
    }
}
