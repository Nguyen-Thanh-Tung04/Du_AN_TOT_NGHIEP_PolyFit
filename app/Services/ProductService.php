<?php

namespace App\Services;

use App\Models\Variant;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function getCategoryAttr() {
        $getCategory = $this->productRepository->getAttr(
            'App\Models\Category',['id','name']
        );
        return $getCategory;
    }

    public function getColorAttr() {
        $getColor = $this->productRepository->getAttr(
            'App\Models\Color',['id','name']
        );
        return $getColor;
    }

    public function getSizeAttr() {
        $getSize = $this->productRepository->getAttr(
            'App\Models\Size',['id','name']
        );
        return $getSize;
    }

    public function paginate($request) {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['status'] = $request->integer('status');
        $perPage = $request->integer('perpage');
        $products = $this->productRepository->pagination([
            'products.id',
            'products.code',
            'products.name',
            'products.gallery',
            'products.description',
            'products.status',
            'products.category_id',
        ], $condition, $perPage, ['id', 'DESC'], [['categories', 'products.category_id', '=', 'categories.id']], ['path' => 'product/index']);
        return $products;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $payloadProduct = $request->only([
                'code', 
                'name', 
                'category_id', 
                'gallery',
                'description',
            ]);
            $payloadProduct['gallery'] = json_encode($payloadProduct['gallery']);
            $product = $this->productRepository->create($payloadProduct);

            if ($product && $product->id > 0) {
                $payloadVariant = $request->only([
                    'color', 
                    'size', 
                    'purchase_price', 
                    'listed_price',
                    'sale_price',
                    'quantity',
                ]);
                // dd($payloadVariant);
                for ($i = 0; $i < count($payloadVariant['color']); $i++) {
                    $variantData = [
                        'product_id' => $product->id,
                        'color_id' => $payloadVariant['color'][$i],
                        'size_id' => $payloadVariant['size'][$i],
                        'purchase_price' => $payloadVariant['purchase_price'][$i],
                        'listed_price' => $payloadVariant['listed_price'][$i],
                        'sale_price' => $payloadVariant['sale_price'][$i],
                        'quantity' => $payloadVariant['quantity'][$i],
                    ];
                    $variant = $this->productRepository->variantCreate($variantData);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request) {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->findById($id);
       
            $payloadProduct = $request->only([
                'code', 
                'name', 
                'category_id', 
                'gallery',
                'description',
            ]);
            $payloadProduct['gallery'] = !empty($payloadProduct['gallery']) ? json_encode($payloadProduct['gallery']) : null;

            
            $flagUpdateProduct = $this->productRepository->update($id, $payloadProduct);
            if ($flagUpdateProduct == true) {
                $payloadVariant = $request->only([
                    'variant_id',
                    'color', 
                    'size', 
                    'purchase_price', 
                    'listed_price',
                    'sale_price',
                    'quantity',
                ]);
                
                for ($i = 0; $i < count($payloadVariant['color']); $i++) {
                    $variantData = [
                        'product_id' => $product->id,
                        'color_id' => $payloadVariant['color'][$i],
                        'size_id' => $payloadVariant['size'][$i],
                        'purchase_price' => $payloadVariant['purchase_price'][$i],
                        'listed_price' => $payloadVariant['listed_price'][$i],
                        'sale_price' => $payloadVariant['sale_price'][$i],
                        'quantity' => $payloadVariant['quantity'][$i],
                    ];
                    if (!empty($payloadVariant['variant_id'][$i])) {
                        // Cập nhật biến thể hiện có
                        $variantUpdate = $this->productRepository->variantUpdate($payloadVariant['variant_id'][$i], $variantData);
                    } else {
                        // Nếu variant_id không tồn tại, đây là biến thể mới => Insert
                        $variantCreate = $this->productRepository->variantCreate($variantData);
                    }
                }
                $delVariantId = $request->input('delete_variant_id');
                if (isset($delVariantId)) {
                    $arrVariantIds = explode(',', rtrim($delVariantId, ','));
                    $deleteVariants = $this->productRepository->deleteVariantById('id', $arrVariantIds);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroyVariant($request) {
        DB::beginTransaction();
        try {
            $delVariantId = $request->input('delete_variant_id');
            if (isset($delVariantId)) {
                $arrVariantIds = explode(',', rtrim($delVariantId, ','));
                $deleteVariants = $this->productRepository->deleteVariantById('id', $arrVariantIds);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatus($post = []) {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1)?2:1);
            $product = $this->productRepository->update($post['modelId'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatusAll($post) {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];

            $flag = $this->productRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }
    
}
