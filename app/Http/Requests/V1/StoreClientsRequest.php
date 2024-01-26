<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoreClientsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $clientUser = Auth::guard("client")->user();
        return $clientUser !== null && $clientUser->tokenCan("create");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "max:255"],
            "email" => ["required", "email", "unique:clients,email"],
            "password" => ["required", "min:8", "max:255"],
            "businessId" => ["required", Rule::exists("businesses", "id")],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "business_id" => $this->businessId,
        ]);
    }
}
