<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlashSaleRequest;
use App\Http\Requests\UpdateFlashSaleRequest;
use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlashSaleController extends Controller
{
    protected $productService;
    protected $productRepository;

    public function __construct(
        ProductService $productService,
        ProductRepository $productRepository,
    ) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }
    public function index(Request $request)
    {
        $statusFilter = $request->input('status');

        $flashSales = FlashSale::withCount('products')
            ->orderBy('date', 'desc')
            ->orderByRaw('CAST(SUBSTRING_INDEX(time_slot, "-", 1) AS UNSIGNED) DESC')
            ->get()
            ->map(function ($flashSale) {
                $startTime = explode('-', $flashSale->time_slot)[0];
                $endTime = explode('-', $flashSale->time_slot)[1];
                $formattedTimeSlot = sprintf('%02d:00-%02d:00', $startTime, $endTime);
                $formattedDate = \Carbon\Carbon::parse($flashSale->date)->format('d/m/Y');
                $currentDateTime = \Carbon\Carbon::now();
                $flashSaleDateTime = \Carbon\Carbon::parse($flashSale->date . ' ' . $startTime . ':00:00');

                if ($flashSaleDateTime->isFuture()) {
                    $status = 'Sắp diễn ra';
                } elseif ($flashSaleDateTime->isPast() && $flashSaleDateTime->addHours($endTime - $startTime)->isFuture()) {
                    $status = 'Đang diễn ra';
                } else {
                    $status = 'Đã diễn ra';
                }

                return [
                    'id' => $flashSale->id,
                    'time_slot' => $formattedTimeSlot . ' ' . $formattedDate,
                    'product_count' => $flashSale->products->unique('product_id')->count(),
                    'status' => $status,
                    'is_active' => $flashSale->status,
                ];
            });

        // Lọc theo trạng thái
        if ($statusFilter) {
            $flashSales = $flashSales->filter(function ($flashSale) use ($statusFilter) {
                return $flashSale['status'] === $statusFilter;
            });
        }

        $config = $this->configData();
        $config['seo'] = config('apps.flashsale');
        $template = 'admin.flashsale.index';
        return view('admin.dashboard.layout', compact('template', 'config', 'flashSales'));
    }

    public function show($id)
    {
        $template = 'admin.flashsale.show';
        $config = $this->configData();
        $config['seo'] = config('apps.flashsale');

        $flashSale = FlashSale::with(['products' => function ($query) {
            $query->with(['product', 'variant']);
        }])->findOrFail($id);

        // Nhóm các variant theo product_id
        $groupedProducts = $flashSale->products->groupBy('product_id');

        // Sử dụng hàm map để xử lý các product và variant theo cấu trúc đối tượng
        $flashSale->products = $groupedProducts->map(function ($variants, $productId) {
            $product = $variants->first()->product; // Lấy đối tượng sản phẩm từ variant đầu tiên

            // Đảm bảo các variant là đối tượng model Eloquent
            $product->variants = $variants->map(function ($flashSaleProduct) {
                return [
                    'variant_id' => $flashSaleProduct->variant_id,
                    'color' => $flashSaleProduct->variant->color->name,
                    'size' => $flashSaleProduct->variant->size->name,
                    'flash_price' => $flashSaleProduct->flash_price,
                    'listed_price' => $flashSaleProduct->listed_price,
                    'discount_percentage' => $flashSaleProduct->discount_percentage,
                    'quantity' => $flashSaleProduct->quantity,
                    'quantity_max' => $flashSaleProduct->variant->quantity,
                    'status' => $flashSaleProduct->status,
                ];
            });

            return $product;
        });
        return view('admin.dashboard.layout', compact('template', 'config', 'flashSale'));
    }

    public function create(Request $request)
    {
        $template = 'admin.flashsale.store';
        $products = Product::with('variants')->where('status', 1)->get();
        $config = [
            'seo' => config('apps.flashsale'),
            'method' => 'create',
            ...$this->configData()
        ];
        return view('admin.dashboard.layout', compact('template', 'config', 'products'));
    }

    public function store(StoreFlashSaleRequest $request)
    {

        $flashSale = FlashSale::create([
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'status' => $request->status
        ]);

        foreach ($request->products as $product) {
            foreach ($product as $variant) {
                FlashSaleProduct::create([
                    'flash_sale_id' => $flashSale->id,
                    'product_id' => $variant['product_id'],
                    'variant_id' => $variant['variant_id'],
                    'flash_price' => $variant['flash_price'],
                    'listed_price' => $variant['listed_price'],
                    'discount_percentage' => $variant['discount_percentage'],
                    'quantity' => $variant['quantity'],
                    'status' => $variant['status']
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Tạo flash sale thành công.',
        ]);
    }

    public function edit($id)
    {
        $flashSale = FlashSale::with(['products' => function ($query) {
            $query->with(['product', 'variant']);
        }])->findOrFail($id);

        // Nhóm các variant theo product_id
        $groupedProducts = $flashSale->products->groupBy('product_id');

        // Sử dụng hàm map để xử lý các product và variant theo cấu trúc đối tượng
        $flashSale->products = $groupedProducts->map(function ($variants, $productId) {
            $product = $variants->first()->product; // Lấy đối tượng sản phẩm từ variant đầu tiên

            // Đảm bảo các variant là đối tượng model Eloquent
            $product->variants = $variants->map(function ($flashSaleProduct) {
                return [
                    'variant_id' => $flashSaleProduct->variant_id,
                    'color' => $flashSaleProduct->variant->color->name,
                    'size' => $flashSaleProduct->variant->size->name,
                    'flash_price' => $flashSaleProduct->flash_price,
                    'listed_price' => $flashSaleProduct->listed_price,
                    'discount_percentage' => $flashSaleProduct->discount_percentage,
                    'quantity' => $flashSaleProduct->quantity,
                    'quantity_max' => $flashSaleProduct->variant->quantity,
                    'status' => $flashSaleProduct->status,
                ];
            });

            return $product;
        });

        $template = 'admin.flashsale.update';
        $products = Product::with('variants')->get();
        $timeSlots = ['0-9', '9-12', '12-15', '15-18', '18-21', '21-24'];
        $occupiedSlots = FlashSale::where('date', $flashSale->date)
            ->where('id', '!=', $flashSale->id)
            ->pluck('time_slot')
            ->toArray();

        // Loại bỏ các time_slot đã có trong cơ sở dữ liệu
        $availableSlots = array_diff($timeSlots, $occupiedSlots);
        $selectedProductIds = $flashSale->products->map(function ($product) {
            return $product->id;
        })->toArray();

        $config = [
            'seo' => config('apps.flashsale'),
            'method' => 'update',
            ...$this->configData()
        ];

        return view('admin.dashboard.layout', compact('template', 'config', 'flashSale', 'products', 'availableSlots', 'selectedProductIds'));
    }

    public function update(UpdateFlashSaleRequest $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $startTime = explode('-', $flashSale->time_slot)[0];
        $flashSaleDateTime = \Carbon\Carbon::parse($flashSale->date . ' ' . $startTime . ':00:00');

        if ($flashSaleDateTime->isPast() && $flashSaleDateTime->addHours(explode('-', $flashSale->time_slot)[1] - $startTime)->isPast()) {
            return response()->json(['status' => false, 'message' => 'Không thể cập nhật flash sale đã kết thúc.']);
        }

        $flashSale->update([
            'status' => $request->status
        ]);

        $flashSale->products()->delete();

        foreach ($request->products as $productId => $variants) {
            foreach ($variants as $variantId => $variant) {
                FlashSaleProduct::create([
                    'flash_sale_id' => $flashSale->id,
                    'product_id' => $productId,
                    'variant_id' => $variant['variant_id'],
                    'flash_price' => $variant['flash_price'],
                    'listed_price' => $variant['listed_price'],
                    'discount_percentage' => $variant['discount_percentage'],
                    'quantity' => $variant['quantity'],
                    'status' => $variant['status']
                ]);
            }
        }

        return response()->json(['status' => true, 'message' => 'Cập nhật flash sale thành công.']);
    }

    public function getOccupiedTimeSlots(Request $request)
    {
        $date = $request->input('date');
        $occupiedSlots = FlashSale::where('date', $date)->pluck('time_slot')->toArray();
        return response()->json(['occupiedSlots' => $occupiedSlots]);
    }

    public function updateStatus(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->status = $request->status;
        $flashSale->save();

        return response()->json(['status' => true, 'message' => 'Cập nhật trạng thái thành công.']);
    }

    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $currentDateTime = \Carbon\Carbon::now();
        $startTime = explode('-', $flashSale->time_slot)[0];
        $flashSaleDateTime = \Carbon\Carbon::parse($flashSale->date . ' ' . $startTime . ':00:00');
        if ($flashSaleDateTime->isPast() && $flashSaleDateTime->addHours(explode('-', $flashSale->time_slot)[1] - $startTime)->isFuture()) {
            return response()->json(['status' => false, 'message' => 'Không thể xóa flash sale đang diễn ra.']);
        } elseif ($flashSaleDateTime->isPast()) {
            return response()->json(['status' => false, 'message' => 'Không thể xóa flash sale đã kết thúc.']);
        }

        $flashSale->delete();

        return response()->json(['status' => true, 'message' => 'Xóa Flash Sale thành công.']);
    }

    public function configData()
    {
        return [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'admin/plugins/ckfinder_2/ckfinder.js',
                'admin/library/finder.js',
                'admin/plugins/ckeditor/ckeditor.js',
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'admin/css/flashsale.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
    }
}
