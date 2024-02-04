<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEvent extends FormRequest
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
            'title' => 'required|string|max:1000',
            'description' => 'required|string',
            'date' => 'nullable',
            'type' => 'required',
            'location' => 'nullable',
            'button' => 'nullable',
            'button_link' => 'nullable',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ];
    }
}
