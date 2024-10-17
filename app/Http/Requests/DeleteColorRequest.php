<?php

namespace App\Http\Requests;

use App\Rules\CheckColorChildrenRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteColorRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'name' => [
                new CheckColorChildrenRule($id),
            ]
        ];
    }
}
