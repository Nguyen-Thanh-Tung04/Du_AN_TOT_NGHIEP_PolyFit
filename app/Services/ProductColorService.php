<?php

namespace App\Services;

use App\Repositories\ProductColorRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductColorService
{
    protected $productColorRepository;

    public function __construct(ProductColorRepository $productColorRepository) {
        $this->productColorRepository = $productColorRepository;
    }

    public function paginate($request) {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perPage = $request->integer('perpage');
        $colors = $this->productColorRepository->pagination([
            'id',
            'name',
        ], $condition, $perPage, ['id', 'DESC'], [], ['path' => 'product/color/index']);
        return $colors;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'name',
            ]);

            for ($i = 0; $i < count($payload['name']); $i++) {
                $colorData = [
                    'name' => $payload['name'][$i],
                ];
                $color = $this->productColorRepository->create($colorData);
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
            $flagUpdateColor = $this->productColorRepository->update($id, $payload);
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
            $color = $this->productColorRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }
    
}
