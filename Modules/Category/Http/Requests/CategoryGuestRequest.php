<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryGuestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:revenue,expense',
            'icon' => 'required|string|max:255',
            'color' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|max:255',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
