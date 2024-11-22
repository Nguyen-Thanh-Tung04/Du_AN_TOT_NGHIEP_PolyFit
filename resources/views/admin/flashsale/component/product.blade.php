<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered" id="product-flash">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                </th>
                <th class="text-center" style="width:100px;">Ảnh</th>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($products) && is_object($products))
            @foreach($products as $product)
            @php
            $gallery = json_decode($product->gallery, true);
            @endphp
            <tr>
                <td>
                    <input type="checkbox" value="{{ $product->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td class="text-center">
                    <span><img class="image img-cover datatable-image" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt=""></span>
                </td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

</div>