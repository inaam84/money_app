<?php

namespace App\Http\Requests\Income;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
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
        return [
            'name' => 'required|max:15',
            'amount' => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'currency' => 'required|in:USD,GBP,PKR,AED,CAD,EUR',
            'user_id' => 'nullable|numeric|in:' . User::pluck('id')->implode(','),
        ];
    }
}
