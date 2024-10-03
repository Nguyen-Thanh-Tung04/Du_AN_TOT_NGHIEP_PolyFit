<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Size;

class CheckSizeChildrenRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    
    protected $id;

    public function __construct($id){
        $this->id = $id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Size::with('variants')->find($this->id);
        if ($product && $product->variants->count() > 0) {
            $fail('Không thể xóa kích thước vì còn sản phẩm chứa thuộc tính này.');
        }
    }
}