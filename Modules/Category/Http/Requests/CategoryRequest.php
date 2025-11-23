<?php
namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Language\Repositories\LanguageRepository;

class CategoryRequest extends FormRequest
{
    protected LanguageRepository $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

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
            'type'      => 'required|string|in:revenue,expense',
            'icon'      => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'default'   => 'nullable|boolean',
        ];

        $languages = $this->languageRepository->allCodes();

        $rules['name'] = ['required', 'array'];

        foreach ($languages as $language) {
            $rules['name.' . $language] = "required|string|max:100";
            $rules['name.' . $language] = "required|string|max:100";
        }

        return $rules;
    }
}
