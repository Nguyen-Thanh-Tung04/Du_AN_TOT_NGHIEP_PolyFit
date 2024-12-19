@extends('client.layouts.master')

@section('content')
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="flash-sale-banner ">
                    <div class="time-sale py-5">
                        <svg viewBox="0 0 108 21" height="21" width="108" class="flash-sale-logo flash-sale-logo--white">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path d="M0 16.195h3.402v-5.233h4.237V8H3.402V5.037h5.112V2.075H0zm29.784 0l-.855-2.962h-4.335l-.836 2.962H20.26l4.723-14.12h3.576l4.724 14.12zM26.791 5.294h-.04s-.31 1.54-.563 2.43l-.797 2.744h2.74l-.777-2.745c-.252-.889-.563-2.43-.563-2.43zm7.017 9.124s1.807 2.014 5.073 2.014c3.13 0 4.898-2.034 4.898-4.384 0-4.463-6.259-4.147-6.259-5.925 0-.79.778-1.106 1.477-1.106 1.672 0 3.071 1.245 3.071 1.245l1.439-2.824s-1.477-1.6-4.47-1.6c-2.76 0-4.918 1.718-4.918 4.325 0 4.345 6.258 4.285 6.258 5.964 0 .85-.758 1.126-1.457 1.126-1.75 0-3.324-1.462-3.324-1.462zm12.303 1.777h3.402v-5.53h5.054v5.53h3.401V2.075h-3.401v5.648h-5.054V2.075h-3.402zm18.64-1.678s1.692 1.915 4.763 1.915c2.877 0 4.548-1.876 4.548-4.107 0-4.483-6.492-3.871-6.492-6.36 0-.987.914-1.678 2.08-1.678 1.73 0 3.052 1.224 3.052 1.224l1.088-2.073s-1.4-1.501-4.12-1.501c-2.644 0-4.627 1.738-4.627 4.068 0 4.305 6.512 3.87 6.512 6.379 0 1.145-.952 1.698-2.002 1.698-1.944 0-3.44-1.48-3.44-1.48zm19.846 1.678l-1.166-3.594h-4.84l-1.166 3.594H74.84L79.7 2.174h2.623l4.86 14.021zM81.04 4.603h-.039s-.31 1.382-.583 2.172l-1.224 3.752h3.615l-1.224-3.752c-.253-.79-.545-2.172-.545-2.172zm7.911 11.592h8.475v-2.192H91.46V2.173H88.95zm10.477 0H108v-2.192h-6.064v-3.772h4.645V8.04h-4.645V4.366h5.753V2.174h-8.26zM14.255.808l6.142.163-3.391 5.698 3.87 1.086-8.028 12.437.642-8.42-3.613-1.025z"></path>
                            </g>
                        </svg>
                        <svg height="20" viewBox="0 0 20 20" width="20" class="shop-svg-icon _17VGnS ">
                            <g fill="none" fill-rule="evenodd" stroke="#fff" stroke-width="1.8" transform="translate(1 1)">
                                <circle cx="9" cy="9" r="9"></circle>
                                <path d="m11.5639648 5.05283203v4.71571528l-2.72832027 1.57129639" stroke-linecap="round" stroke-linejoin="round" transform="matrix(-1 0 0 1 20.39961 0)"></path>
                            </g>
                        </svg>

                        <div class="d-flex align-items-center ">
                            @if($flashSale)

                            <div class="d-flex  align-items-center ">
                                <div>
                                    <h5 class="fs-5 text-white mr-2">Kết thúc trong</h5>
                                </div>

                                <div id="flash-sale-countdown" class="countdown-timer mt-2">
                                    <span id="hours">00</span>
                                    <span id="minutes">00</span>
                                    <span id="seconds">00</span>
                                </div>
                            </div>
                            @else
                            <div class="text-center">
                                <p class="text-light fs-5">
                                    Hiện tại không có chương trình flash sale
                                </p>

                            </div>
                            @endif

                        </div>
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
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                        <!-- START single card -->
                        <div class="ec-product-tp">
                            <div class="ec-product-image">
                                <a href="{{ route('client.product.show', $product->id) }}">
                                    <img src="{{ !empty($gallery) ? $gallery[0] : '' }}" class="img-center" alt="">
                                    @if($product->variants->sum('quantity') === 0)
                                    <div class="out-of-stock-label">Hết hàng</div>
                                    @endif
                                </a>
                                <span class="ec-product-ribbon">-{{number_format($product->discount_percentage)}}%</span>
                            </div>
                            <div class="ec-product-body">
                                <h3 class="ec-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h3>

                                <ul class="ec-rating">
                                    @php
                                    $averageScore = $product->averageScore();
                                    @endphp

                                    @if ($averageScore)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=$averageScore)
                                        <li class="ecicon eci-star fill">
                                        </li> <!-- Sao đầy -->
                                        @else
                                        <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                        @endif
                                        @endfor
                                        @else
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=5)
                                            <li class="ecicon eci-star fill">
                                            </li> <!-- Sao đầy -->
                                            @else
                                            <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                            @endif
                                            @endfor
                                            @endif
                                </ul>
                                <div class="ec-price">
                                    <span>{{ number_format($product->listed_price, 0) }}₫</span> {{ number_format($product->flash_sale_price, 0) }}₫
                                </div>
                                {{-- <div class="ec-link-btn">
                                    <a class=" ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Mua ngay</a>
                            </div> --}}
                        </div>

                    </div>
                    <!-- START single card -->
                </div>
                @endforeach
            </div>
            @else
            @if($flashSale)
            <div class="text-center p-5">
                <h4 class="text-black">
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