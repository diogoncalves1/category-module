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


        $rules["name"] = ["nullable", function ($attribute, $value, $fail) {
            $languages = Language::cases();

            if (!is_array($value) && !is_string($value))
                return $fail('Array or String type required');

            if (is_array($value)) {
                foreach ($value as $lang => $translation) {
                    if (!is_string($translation)) {
                        return $fail("A tradução para {$lang} deve ser uma string.");
                    }

                    if (mb_strlen($translation) > 100) {
                        return $fail("A tradução para {$lang} não pode ter mais que 100 caracteres.");
                    }
                }
            }
        }];

        return $rules;
    }
}
