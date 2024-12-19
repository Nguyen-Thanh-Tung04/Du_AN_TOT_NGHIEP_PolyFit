<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th style="width:50px">
                STT
            </th>
            <th>Tên chức năng</th>
            <th>Đường dẫn</th>
            <th class="text-center">Thao Tác</th>
        </tr>
        </thead>
        <tbody>
            @if (isset($permissions) && is_object($permissions))
                @foreach($permissions as $key => $permission)
                @php
                    $gallery = json_decode($permission->gallery, true);
                @endphp
                <tr>
                    <td class="text-center">
                        {{ $key + 1 }}
                    </td>
                    <td>
                        {{ $permission->name }}
                    </td>
                    <td><span class="text-danger">({{ $permission->canonical }})</span></td>
                    <td class="text-center">
                        <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('permission.delete', $permission->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $permissions->links('pagination::bootstrap-5') }}
    
</div>