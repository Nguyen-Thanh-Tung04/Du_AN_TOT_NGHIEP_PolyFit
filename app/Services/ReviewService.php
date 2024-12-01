<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Repositories\Interfaces\ReviewInterface as ReviewRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Class ReviewService.
 */
class ReviewService
{
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
            'repluy' => $request->input('repluy'),
            'score'  => $request->input('score'),

        ];
        $perPage = $request->input('perpage') ?? 10; // Sử dụng giá trị mặc định nếu perpage là null

        $reviews = $this->ReviewRepository->pagination(
            ['id', 'product_id', 'account_id', 'content', 'image', 'score', 'status'],
            $condition,
            $perPage
        );

        return $reviews;
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Tìm đánh giá cần xóa theo ID
            $review = $this->ReviewRepository->find($id);

            if (!$review) {
                throw new \Exception('Review not found');
            }

            // Lấy order_id từ đánh giá, để tìm tất cả các sản phẩm liên quan đến đơn hàng
            $orderId = $review->order_id; // Giả sử review có order_id liên kết với đơn hàng
            $order = Order::findOrFail($orderId);

            // Lấy tất cả sản phẩm (orderItems) từ đơn hàng
            $orderItems = $order->orderItems;

            // Xóa tất cả các đánh giá của các sản phẩm trong đơn hàng đó
            // foreach ($orderItems as $orderItem) {
            //     // Tìm và xóa tất cả đánh giá của sản phẩm trong orderItem
            //     Review::where('product_id', $orderItem->variant->product_id)
            //         ->where('order_id', $orderId) // Chỉ xóa đánh giá trong cùng đơn hàng
            //         ->delete();
            // }
            foreach ($orderItems as $orderItem) {
                $reviewItems = Review::where('product_id', $orderItem->variant->product_id)
                    ->where('order_id', $orderId)
                    ->get();

                foreach ($reviewItems as $review) {
                    $review->delete();
                }
            }

            // Xóa phản hồi của đánh giá ban đầu
            ReviewReply::where('review_id', $review->id)->delete(); // Xóa các phản hồi của đánh giá ban đầu
            // If review has an image, delete it from storage
            if ($review->image) {
                Storage::delete($review->image);
            }
            // Xóa chính đánh giá ban đầu
            $this->ReviewRepository->delete($id);

            // Commit sau khi mọi thứ đều hoàn tất
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            // Log lỗi nếu cần thiết
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
            $user = $this->ReviewRepository->update($post['modelId'], $payload);
            $this->changReviewStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];
            $flag = $this->ReviewRepository->updateByWhereIn('id', $post['id'], $payload);
            $this->changReviewStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }

    private function changReviewStatus($post, $value)
    {

        DB::beginTransaction();
        try {
            $array = [];
            if (isset($post['modelId'])) {
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

            echo $e->getMessage();
            die();
            return false;
        }
    }
}
