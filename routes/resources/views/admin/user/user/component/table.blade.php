<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th>
                STT
            </th>
            <th class="text-center" style="width:100px;">Ảnh</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Số Điện Thoại</th>
            <th>Vai trò</th>
            <th class="text-center">Tình Trạng</th>
            @if (Auth::user()->user_catalogue_id == 1)
                <th class="text-center">Thao Tác</th>
            @endif
        </tr>
        </thead>
        <tbody>
            @if (isset($users) && is_object($users))
                @foreach($users as $key => $user)
                @if ($user->user_catalogues->id == 1 || $user->user_catalogues->id == 3) 
                    @continue; 
                @endif
                <tr>
                    <td>
                        {{ $key + 1}}
                    </td>
                    <td class="text-center">
                        <span><img class="image img-cover" src="{{ $user->image }}" alt=""></span>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->user_catalogues->name }}</td>
                    <td class="text-center js-switch-{{ $user->id }}">
                        <input type="checkbox" value="{{ $user->publish }}"
                        {{ Auth::user()->user_catalogue_id != 1 ? 'disabled' : '' }}
                        class="js-switch status "
                        data-field="publish"
                        data-model="User"
                        data-modelId="{{ $user->id }}"
                        {{ ($user->publish == 1) ? 'checked' : '' }}/>
                    </td>
                    @if (Auth::user()->user_catalogue_id == 1)
                    <td class="text-center">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            
                            {{-- <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a> --}}
                        </td>
                        @endif
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $users->links('pagination::bootstrap-5') }}

</div>
