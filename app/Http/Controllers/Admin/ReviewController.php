<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ReviewService;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Models\ReviewReply;
// use App\Http\Requests\UpdateReviewRequest;
use App\Repositories\Interfaces\ReviewInterface as ReviewRepository;


class ReviewController extends Controller
{
    protected $ReviewService;
    protected $ReviewRepository;

    public function __construct(
        ReviewService $ReviewService,
        ReviewRepository $ReviewRepository,
    ) {
        $this->ReviewService = $ReviewService;
        $this->ReviewRepository = $ReviewRepository;
    }

    public function index(StoreReviewRequest $request)
    {
        $reviews = $this->ReviewService->paginate($request);
        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
        $config['seo'] = config('apps.review');
        $template = 'admin.reviews.index';
        return view('admin.dashboard.layout', compact('template', 'config', 'reviews'));
    }
    public function edit($id)
    {
        // Lấy review dựa vào ID
        $reviews = $this->ReviewRepository->find($id);
    
        // Lấy phản hồi nếu có, bạn có thể sử dụng where để tìm phản hồi theo review_id
        $reply = ReviewReply::where('review_id', $id)
        ->with('user') // Load quan hệ với User
        ->first();    
        // Cấu hình các file JS, CSS cần thiết
        $template = 'admin.reviews.update';
        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
    
        $config['seo'] = config('apps.review');
        $config['method'] = 'edit';
    
        // Truyền biến $reply sang view để kiểm tra và hiển thị
        return view('admin.dashboard.layout', compact(
            'template',
            'reviews',
            'reply',  // Truyền thêm $reply vào view
            'config'
        ));
    }
    
    public function delete($id)
    {
        $review = $this->ReviewRepository->find($id);
        $config = [
            'seo' => config('apps.review'),
        ];
        $template = 'admin.reviews.delete';
        return view('admin.dashboard.layout', compact('template', 'config', 'review'));
    }
    public function destroy($id)
    {
        if ($this->ReviewService->destroy($id)) {
            return redirect()->route('reviews.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('reviews.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }
    public function storeReply(Request $request, $reviewId)
    {
        // Xác thực dữ liệu
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
    
        // Lấy review để xác định order
        $review = Review::findOrFail($reviewId);
        $orderId = $review->order_id;
    
        // Lấy tất cả các review trong cùng một order
        $reviews = Review::where('order_id', $orderId)->get();
    
        foreach ($reviews as $review) {
            // Kiểm tra xem đã có phản hồi cho đánh giá này chưa
            $existingReply = ReviewReply::where('review_id', $review->id)->first();
    
            if ($existingReply) {
                // Nếu đã có phản hồi, cập nhật nội dung phản hồi và user_id mới
                $existingReply->update([
                    'content' => $request->input('content'),
                    'user_id' => auth()->id(),  // Thay đổi user_id thành người dùng hiện tại
                ]);
            } else {
                // Nếu chưa có phản hồi, tạo phản hồi mới
                ReviewReply::create([
                    'review_id' => $review->id,   // Lưu lại ID của review
                    'user_id' => auth()->id(),    // Gán user_id của người dùng hiện tại
                    'content' => $request->input('content'),
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Trả lời đánh giá thành công cho tất cả sản phẩm trong đơn hàng!');
    }
    
    
    
}