<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LinkRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:8|max:255',
            'description' => 'required|min:8',
            'url' => 'required|url',
            'site' => ['required', Rule::exists('sites','name')->where(function ($query) {
                $query->where('user_id', auth()->id());
            })],
            'status' => 'boolean',
        ];
    }
}
