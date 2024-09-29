<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center" style="width:100px;">Ảnh</th>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Mô tả</th>
            <th class="text-center">Tình Trạng</th>
            <th class="text-center">Thao Tác</th>
        </tr>
        </thead>
        <tbody>
            @if (isset($products) && is_object($products))
                @foreach($products as $product)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $product->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td class="text-center">
                        <span><img class="image img-cover" src="{{ $product->gallery }}" alt=""></span>
                    </td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->categories->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td class="text-center js-switch-{{ $product->id }}">
                        <input type="checkbox" value="{{ $product->status }}" 
                        class="js-switch status " 
                        data-field="status" 
                        data-model="Product"
                        data-modelId="{{ $product->id }}"
                        {{ ($product->status == 1) ? 'checked' : '' }}/>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>

                        <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $products->links('pagination::bootstrap-5') }}
    
</div>