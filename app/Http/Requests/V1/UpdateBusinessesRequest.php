<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        if ($this->method() === "PUT") {
            return [
                "name" => ["required", "max:255"],
                "email" => ["required", "email", "unique:businesses,email"],
                "password" => ["required", "min:8", "max:255"],
            ];
        }

        if ($this->method() === "PATCH") {
            return [
                "name" => ["sometimes", "required", "max:255"],
                "email" => ["sometimes", "required", "email", "unique:businesses,email"],
                "password" => ["sometimes", "required", "min:8", "max:255"],
            ];
        }
    }
}
