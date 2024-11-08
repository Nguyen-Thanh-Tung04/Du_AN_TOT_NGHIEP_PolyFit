<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">STT</th>
            <th class="text-center">Tên kích cỡ</th>
            <th class="text-center">Thao Tác</th>
        </tr>
        </thead>
        <tbody>
            @if (isset($sizes) && is_object($sizes))
                @foreach($sizes as $index => $size)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $size->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td class="text-center">{{ $index + 1}}</td>
                    <td class="text-center">{{ $size->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('product.size.edit', $size->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('product.size.delete', $size->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $sizes->links('pagination::bootstrap-5') }}
    
</div>