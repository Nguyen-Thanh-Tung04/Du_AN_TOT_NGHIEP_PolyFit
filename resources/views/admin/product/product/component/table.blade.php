<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <td class="text-center">
                    STT
                </td>
                <th class="text-center" style="width:100px;">Ảnh</th>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th class="text-center">Tình Trạng</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($products) && is_object($products))
            @foreach($products as $key => $product)
            @php
            $gallery = json_decode($product->gallery, true);
            @endphp
            <tr>
                <td class="text-center">
                    {{ $key + 1 }}
                </td>
                <td class="text-center">
                    <span><img class="image img-cover" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt=""></span>
                </td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td class="text-center js-switch-{{ $product->id }}">
                    <input type="checkbox" value="{{ $product->status }}"
                        class="js-switch status "
                        data-field="status"
                        data-model="Product"
                        data-modelId="{{ $product->id }}"
                        {{ ($product->status == 1) ? 'checked' : '' }} />
                </td>
                <td class="text-center">
                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    {{-- <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a> --}}
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    {{ $products->links('pagination::bootstrap-5') }}

</div>