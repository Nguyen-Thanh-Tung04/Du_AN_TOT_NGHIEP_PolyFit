<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|unique:products,code, ' .$this->id,
            'name' => 'required', 
            'category_id' => 'gt:0',
            'color.*' => 'gt:0', 
            'size.*' => 'gt:0', 
            'purchase_price.*' => 'required|integer|min:1|max:9999999', 
            'listed_price.*' => 'required|integer|min:1|max:9999999',
            'sale_price.*' => 'integer|min:1|max:9999999',
            'quantity.*' => 'required|integer|min:1|max:9999999',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $purchasePrices = $this->input('purchase_price', []);
            $listedPrices = $this->input('listed_price', []);
            $salePrices = $this->input('sale_price', []);

            foreach ($purchasePrices as $index => $purchasePrice) {
                $listedPrice = $listedPrices[$index] ?? 0;
                $salePrice = $salePrices[$index] ?? 0;

                if ($purchasePrice >= $listedPrice) {
                    $validator->errors()->add("purchase_price.{$index}", 'Giá niêm yết phải lớn hơn giá nhập kho.');
                }

                if ($listedPrice <= $salePrice) {
                    $validator->errors()->add("sale_price.{$index}", 'Giá sale phải nhỏ hơn giá niêm yết.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Bạn chưa nhập mã sản phẩm..',
            'code.unique' => 'Mã sản phẩm đã tồn tại..',
            'name.required' => 'Bạn chưa nhập tên sản phẩm.',
            'category_id.gt' => 'Bạn chưa chọn danh mục.',
            'color.*.gt' => 'Bạn chưa chọn màu sắc.',
            'size.*.gt' => 'Bạn chưa chọn kích cỡ.',
            'purchase_price.*.required' => 'Bạn chưa nhập giá nhập kho.',
            'purchase_price.*.integer' => 'Giá nhập kho phải là dạng số nguyên.',
            'purchase_price.*.min' => 'Giá nhập kho phải lớn hơn 1.',
            'purchase_price.*.max' => 'Giá nhập kho quá lớn.',
            'listed_price.*.required' => 'Bạn chưa nhập giá niêm yết.',
            'listed_price.*.integer' => 'Giá niêm yết phải là dạng số nguyên.',
            'listed_price.*.min' => 'Giá niêm yết phải lớn hơn 1.',
            'listed_price.*.max' => 'Giá niêm yết quá lớn.',
            'sale_price.*.integer' => 'Giá sale phải là dạng số nguyên.',
            'sale_price.*.min' => 'Giá sale phải lớn hơn 1.',
            'sale_price.*.max' => 'Giá sale quá lớn.',
            'quantity.*.required' => 'Bạn chưa nhập số lượng.',
            'quantity.*.integer' => 'Số lượng phải là dạng số nguyên.',
            'quantity.*.min' => 'Số lượng phải lớn hơn 1.',
            'quantity.*.max' => 'Số lượng quá lớn.',
        ];
    }
}
