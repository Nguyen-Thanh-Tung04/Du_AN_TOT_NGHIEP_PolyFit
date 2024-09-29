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

        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');

        $CategoryRepository = $this->CategoryRepository->pagination([
            'id',
            'code',
            'name',
            'image',
            'is_active'
        ], $condition, $perPage);

        return $CategoryRepository;
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
}
