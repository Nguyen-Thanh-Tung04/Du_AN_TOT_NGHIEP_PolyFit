@extends('client.layouts.master')

@section('content')
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="flash-sale-banner text-white p-3 mb-4">
                    <div class="d-flex flex-column align-items-center">
                        @if($flashSale)
                        <div>
                            <p><span id="flash-sale-date">{{ \Carbon\Carbon::parse($flashSaleEndTime)->format('H:i d/m/Y') }}</span></p>
                        </div>
                        <div>
                            <h5 class="fs-5">Kết thúc trong</h5>
                            <div id="flash-sale-countdown" class="countdown-timer mt-2">
                                <span id="hours">00</span>
                                <span id="minutes">00</span>
                                <span id="seconds">00</span>
                            </div>
                        </div>
                        @else
                        <div class="text-center">
                            <h2 class="text-light">
                                Hiện tại không có chương trình flash sale
                            </h2>

                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-12">
                @if($flashSale && $products->isNotEmpty())
                <div class="row">
                    @foreach($products as $product)
                    @php
                    $gallery = json_decode($product->gallery);
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="ec-product-ds">
                            <div class="ec-product-image {{ $product->variants->sum('quantity') === 0 ? 'out-of-stock' : '' }}">
                                <a href="{{ route('client.product.show', $product->id) }}" class="image">
                                    <img class="pic-1" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt="" />
                                </a>
                                @if($product->variants->sum('quantity') === 0)
                                <div class="out-of-stock-label">Hết hàng</div>
                                @endif
                                <span class="ec-product-discount-label">-{{number_format($product->discount_percentage)}}%</span>
                            </div>
                            <div class="ec-product-body">
                                @if ($product->averageScore())
                                <ul class="ec-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=round($product->averageScore()))
                                        <li class="ecicon eci-star fill"></li>
                                        @else
                                        <li class="ecicon eci-star"></li>
                                        @endif
                                        @endfor
                                </ul>
                                @else
                                <ul class="ec-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=5)
                                        <li class="ecicon eci-star fill">
                                        </li>
                                        @else
                                        <li class="ecicon eci-star"></li>
                                        @endif
                                        @endfor
                                </ul>
                                @endif
                                <h3 class="ec-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h3>
                                <div class="ec-price">
                                    <span>{{ number_format($product->listed_price, 0) }} ₫</span>
                                    {{ number_format($product->flash_sale_price, 0) }} ₫
                                </div>
                                <a class="ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                @if($flashSale)
                <div class="text-center p-5">
                    <h4>
                        Hiện tại không có sản phẩm trong chương trình flash sale
                    </h4>

                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {


        function countDown(time) {
            // Cập nhật đếm ngược mỗi giây
            var countdownFunction = setInterval(function() {
                var now = new Date().getTime();
                var distance = time - now;

                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (hours < 10) hours = "0" + hours;
                if (minutes < 10) minutes = "0" + minutes;
                if (seconds < 10) seconds = "0" + seconds;

                $("#hours").text(hours);
                $("#minutes").text(minutes);
                $("#seconds").text(seconds);

                if (distance < 0) {
                    clearInterval(countdownFunction);
                    $("#flash-sale-countdown").text("Hết giờ");
                }
            }, 1000);
        }

        countDown(new Date("{{ $flashSaleEndTime }}").getTime());

    });
</script>
@endsection