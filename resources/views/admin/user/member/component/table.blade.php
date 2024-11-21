<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center" style="width:100px;">Ảnh</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Vai trò</th>
            <th class="text-center">Tình Trạng</th>
            <th class="text-center">Thao Tác</th>
        </tr>
        </thead>
        <tbody>
            @if (isset($members) && is_object($members))
                @foreach($members as $member)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $member->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td class="text-center">
                        <span><img class="image img-cover" src="{{ $member->image }}" alt=""></span>
                    </td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->address }}</td>
                    <td>{{ $member->user_catalogues->name }}</td>
                    <td class="text-center js-switch-{{ $member->id }}">
                        <input type="checkbox" value="{{ $member->publish }}"
                               class="js-switch status "
                               data-field="publish"
                               data-model="User"
                               data-modelId="{{ $member->id }}"
                            {{ ($member->publish == 1) ? 'checked' : '' }}/>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('member.delete', $member->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $members->links('pagination::bootstrap-5') }}

</div>
