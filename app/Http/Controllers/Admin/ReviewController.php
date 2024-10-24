<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ReviewService;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Models\ReviewHistory;
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
    public function history(StoreReviewRequest $request)
    {
        // Chuẩn bị query để lấy dữ liệu đánh giá và lịch sử, bao gồm cả đánh giá đã xóa mềm
        $query = Review::withTrashed()  // Lấy cả dữ liệu đã bị xóa mềm
            ->join('users', 'reviews.account_id', '=', 'users.id')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->join('orders', 'reviews.order_id', '=', 'orders.id') // Join với bảng orders
            ->leftJoin('review_histories', 'reviews.id', '=', 'review_histories.review_id') // Join với bảng review_histories
            ->where('review_histories.action', 'create') // Điều kiện lọc theo action 'create'
            ->where('review_histories.type', 'review') // Điều kiện lọc theo type 'review'
            ->select(
                'reviews.*',
                'users.email',
                'users.name',
                'users.image',
                'products.code as product_code',
                'orders.id as order_id', // Select order ID
                'review_histories.id as history_id',
                'review_histories.action as history_action',
                'review_histories.type as history_type'
            )
            ->orderBy('reviews.id', 'desc'); // Sắp xếp theo review ID
    
        // Lấy điều kiện tìm kiếm từ request
        $conditions = [
            'keyword' => $request->input('keyword'),
            'status' => $request->input('status'),
            'repluy' => $request->input('repluy'),
            'score' => $request->input('score'),
            'trashed' => $request->input('trashed') // Lọc theo đánh giá bị xóa mềm
        ];
    
        // Thêm điều kiện tìm kiếm theo từ khóa
        if (!empty($conditions['keyword'])) {
            $query->where(function ($q) use ($conditions) {
                $q->where('orders.code', 'like', '%' . $conditions['keyword'] . '%')
                    ->orWhere('users.email', 'like', '%' . $conditions['keyword'] . '%');
            });
        }
    
        // Thêm điều kiện lọc theo trạng thái (nếu có)
        if (!is_null($conditions['status'])) {
            $query->where('reviews.status', $conditions['status']);
        }
    
        // Lọc theo trạng thái trả lời hay chưa (repluy)
        if (!is_null($conditions['repluy'])) {
            if ($conditions['repluy'] == 1) {
                $query->whereHas('replies'); // Đánh giá đã trả lời
            } elseif ($conditions['repluy'] == 2) {
                $query->doesntHave('replies'); // Đánh giá chưa trả lời
            }
        }
    
        // Thêm điều kiện lọc theo score (điểm đánh giá)
        if (!empty($conditions['score'])) {
            $query->where('reviews.score', '=', $conditions['score']);
        }
    
        // Thêm điều kiện lọc theo đánh giá đã bị xóa mềm
        if (!is_null($conditions['trashed'])) {
            if ($conditions['trashed'] == 1) {
                $query->onlyTrashed(); // Chỉ lấy đánh giá đã bị xóa mềm
            }
        }
    
        // Lấy số bản ghi trên mỗi trang từ request (mặc định là 10)
        $perPage = $request->input('perpage', 10);
    
        // Thực hiện phân trang và lấy kết quả
        $reviewHistories = $query->paginate($perPage);
    
        // Cấu hình JS và CSS cho trang
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
        $template = 'admin.reviews.history';
    
        // Trả về view với dữ liệu đã phân trang
        return view('admin.dashboard.layout', compact('template', 'config', 'reviewHistories'));
    }
    


    public function showReviewHistory($reviewId)
    {
        // Lấy thông tin đánh giá chính, bao gồm cả những đánh giá đã xóa mềm
        $review = Review::withTrashed()->with('replies')->findOrFail($reviewId);

        // Lấy toàn bộ lịch sử của đánh giá và phản hồi, bao gồm cả những bản ghi đã bị xóa mềm
        $reviewsHistory = ReviewHistory::withTrashed() // Thêm withTrashed để lấy cả các bản ghi đã bị xóa mềm
            ->where('review_id', $reviewId)
            ->orWhere('reply_id', $review->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Cấu hình file js và css
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
        $template = 'admin.reviews.history_detail';

        return view('admin.dashboard.layout', compact('template', 'config', 'reviewsHistory'));
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