<?php

namespace App\Services;

use App\Models\Variant;
use App\Repositories\ProductSizeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductSizeService
{
    protected $productSizeRepository;

    public function __construct(ProductSizeRepository $productSizeRepository) {
        $this->productSizeRepository = $productSizeRepository;
    }

    public function paginate($request) {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perPage = $request->integer('perpage');
        $sizes = $this->productSizeRepository->pagination([
            'id',
            'name',
        ], $condition, $perPage, ['id', 'DESC'], [], ['path' => 'product/size/index']);
        return $sizes;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'name',
            ]);

            for ($i = 0; $i < count($payload['name']); $i++) {
                $sizeData = [
                    'name' => $payload['name'][$i],
                ];
                $size = $this->productSizeRepository->create($sizeData);
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
            $payload = $request->except(['_token', 'send']);
            $flagUpdateSize = $this->productSizeRepository->update($id, $payload);
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
            $size = $this->productSizeRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }
    
}
