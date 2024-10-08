<?php

namespace App\Services;

use App\Repositories\Interfaces\ReviewInterface as ReviewRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Class ReviewService.
 */
class ReviewService {
    protected $ReviewRepository;

    public function __construct(
        ReviewRepository $ReviewRepository
    ) {
        $this->ReviewRepository = $ReviewRepository;
    }
    public function paginate($request)
    {
        $condition = [
            'keyword' => $request->input('keyword'),
            'status' => $request->input('status'),
            'repluy' => $request->input('repluy')
        ];
        $perPage = $request->input('perpage') ?? 10; // Sử dụng giá trị mặc định nếu perpage là null
    
        $reviews = $this->ReviewRepository->pagination(
            ['id', 'product_id', 'account_id','content', 'image', 'score', 'status'],
            $condition,
            $perPage
        );
    
        return $reviews;
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $review = $this->ReviewRepository->find($id);

            if ($review && $review->image) {
                // Xóa ảnh cũ từ hệ thống trước khi lưu ảnh mới
                Storage::delete($review->image);
            }
            $review = $this->ReviewRepository->delete($id);
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
            $user = $this->ReviewRepository->update($post['modelId'], $payload);
            $this->changReviewStatus($post, $payload[$post['field']]);

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
            $flag = $this->ReviewRepository->updateByWhereIn('id', $post['id'], $payload);
            $this->changReviewStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    private function changReviewStatus($post, $value) {

        DB::beginTransaction();
        try {
            $array = [];
            if(isset($post['modelId'])) {
                $array[] = $post['modelId'];
            } else {
                $array = $post['id'];
            }
            $payload[$post['field']] = $value;
            $this->ReviewRepository->updateByWhereIn('id', $array, $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }
}