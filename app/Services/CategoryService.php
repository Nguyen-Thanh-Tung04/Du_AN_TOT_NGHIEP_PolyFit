<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryInterface as CategoryRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Class CategoryService.
 */
class CategoryService
{
    protected $CategoryRepository;

    public function __construct(
        CategoryRepository $CategoryRepository
    ) {
        $this->CategoryRepository = $CategoryRepository;
    }
    public function paginate($request)
    {
        $condition = [
            'keyword' => $request->input('keyword'),
            'is_active' => $request->input('is_active')
        ];
        $perPage = $request->input('perpage') ?? 10; // Sử dụng giá trị mặc định nếu perpage là null
    
        $categories = $this->CategoryRepository->pagination(
            ['id', 'code', 'name', 'image', 'is_active'],
            $condition,
            $perPage
        );
    
        return $categories;
    }
    public function create(array $data, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);

            if ($request->hasFile('image')) {
                // Xử lý hình ảnh mới nếu có
                $imagePath = $request->file('image')->store('public/category');
                $payload['image'] = $imagePath;
            }

            $category = $this->CategoryRepository->create($data, $payload); // Truyền cả $data và $payload vào phương thức create()

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $category = $this->CategoryRepository->find($id);

            if (!$category) {
                throw new \Exception('Category not found');
            }

            $payload = $request->except(['_token', 'send']);

            if ($request->hasFile('image')) {
                // Kiểm tra xem có ảnh cũ không
                if ($category->image) {
                    // Xóa ảnh cũ từ hệ thống trước khi lưu ảnh mới
                    Storage::delete($category->image);
                }
                // Xử lý hình ảnh mới nếu có
                $imagePath = $request->file('image')->store('public/category');
                $payload['image'] = $imagePath;
            }

            $user = $this->CategoryRepository->update($id, $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = $this->CategoryRepository->find($id);

            if ($category && $category->image) {
                // Xóa ảnh cũ từ hệ thống trước khi lưu ảnh mới
                Storage::delete($category->image);
            }
            $category = $this->CategoryRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }
    public function updateStatus($post = []) {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 0)?1:0);
            $user = $this->CategoryRepository->update($post['modelId'], $payload);
            $this->changCategoryStatus($post, $payload[$post['field']]);

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
            $flag = $this->CategoryRepository->updateByWhereIn('id', $post['id'], $payload);
            $this->changCategoryStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    private function changCategoryStatus($post, $value) {

        DB::beginTransaction();
        try {
            $array = [];
            if(isset($post['modelId'])) {
                $array[] = $post['modelId'];
            } else {
                $array = $post['id'];
            }
            $payload[$post['field']] = $value;
            $this->CategoryRepository->updateByWhereIn('id', $array, $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }
}