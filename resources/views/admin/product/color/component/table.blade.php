<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">STT</th>
            <th class="text-center">Tên màu sắc</th>
            <th class="text-center">Thao Tác</th>
        </tr>
        </thead>
        <tbody>
            @if (isset($colors) && is_object($colors))
                @foreach($colors as $index => $color)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $color->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td class="text-center">{{ $index + 1}}</td>
                    <td class="text-center">{{ $color->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('product.color.edit', $color->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('product.color.delete', $color->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $colors->links('pagination::bootstrap-5') }}
    
</div>