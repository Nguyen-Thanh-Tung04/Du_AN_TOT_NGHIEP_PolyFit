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
                        <td class="text-center">
                            <img width="100px" src="{{ asset(Storage::url($category->image)) }}" alt="">
                        </td>
                        <td class="text-center js-switch-{{ $category->id }}">
                            <input type="checkbox" value="{{ $category->is_active }}" 
                            class="js-switch status " 
                            data-field="is_active" 
                            data-model="category"
                            data-modelId="{{ $category->id }}"
                            {{ ($category->is_active == 1) ? 'checked' : '' }} />
                        </td>   
                         <td class="text-center">
                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
    
                            <a href="{{ route('category.delete', $category->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{-- {{ $categories->links('pagination::bootstrap-5') }} --}}
</div>