<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Activities extends FormRequest
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
            'title' => 'nullable|string|max:1000',
            'description' => 'required|string',
            'type' => 'required',
            'web' => 'required',
            'file' => 'nullable'
            // 'file' =>[
            //     'image','mimes:jpeg,png,jpg,gif,svg','max:1024',
            //     Rule::requiredIf($this->id==null),
            // ],
        ];
    }
}
