<?php

namespace App\Http\Requests\auth;

use App\laravel_messenger\HttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use JetBrains\PhpStorm\ArrayShape;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(["username" => "string[]", "email" => "string[]", "first_name" => "string[]", "last_name" => "string[]", "password" => "string[]"])] public function rules()
    {
        return [
            "username" => ["required", "unique:users,username"],
            "email" => ["required", "unique:users,username"],
            "first_name" => ["required", "min:3"],
            "last_name" => ["required", "min:3"],
            "password" => ["required"],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "message" => "validation failed",
            "errors" => $validator->errors()
        ], HttpStatus::BAD_REQUEST));
    }
}
