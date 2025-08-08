<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use app\Enums\Language;

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
            'user_id' => 'nullable|exists:users,id',
            'default' => 'nullable|boolean',
            'name' => 'nullable|string|max:100'
        ];

        $languages = Language::cases();

        $rules["name"] = "nullable|array";

        foreach ($languages as $language) {
            $rules['name.' . $language->name] = "required|string|max:100";
        }

        return $rules;
    }
}
