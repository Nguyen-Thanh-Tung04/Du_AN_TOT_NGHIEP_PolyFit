<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                </th>
                <th class="text-center">Mã</th>
                <th>Tên danh mục</th>
                <th class="text-center">Ảnh danh mục</th>
                <th class="text-center">Tình Trạng</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($categories) && is_object($categories))
                @foreach($categories as $category)
                    <tr>
                        <td>
                            <input type="checkbox" value="{{ $category->id }}" class="input-checkbox checkBoxItem">
                        </td>
                        <td>{{ $category->code }}</td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center">{{ $category->image }}</td>
                        <td class="text-center">{{ $category->is_active }}</td>
                        <td class="text-center">
                            <a href="" class="btn btn-success"><i class="fa fa-edit"></i></a>
    
                            <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{-- {{ $categories->links('pagination::bootstrap-5') }} --}}
</div>