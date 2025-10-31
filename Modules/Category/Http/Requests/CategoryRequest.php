<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
            'type' => 'required|string|in:revenue,expense',
            'icon' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'default' => 'nullable|boolean',
        ];

        $languages = config('languages');

        $rules['name'] = ['nullable', 'array'];
        $rules['name.*'] = ['in:' . implode(',', $languages)];

        return $rules;
    }
}
