<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class DestroyCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Add validation logic before deleting a category.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // No need for specific validation rules, we handle logic in the withValidator method
        ];
    }

    /**
     * Hook into the validator to add custom validation logic.
     */
    public function withValidator($validator)
    {
        $categoryId = $this->route('id'); // Get the category ID from the route
        $category = Category::find($categoryId); // Retrieve the category

        if ($category && $category->products()->count() > 0) {
            $validator->after(function ($validator) {
                $validator->errors()->add('category', 'Không thể xóa danh mục vì vẫn còn sản phẩm thuộc danh mục này.');
            });
        }
    }
}