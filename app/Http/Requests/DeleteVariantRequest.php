<?php

namespace App\Http\Requests;

use App\Rules\CheckVariantChildrenRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Variant;

class DeleteVariantRequest extends FormRequest
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
    public function rules()
    {
        return [
            'variant_id' => [new CheckVariantChildrenRule($this->delete_variant_id)],
        ];
    }
}
