<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th class="text-center">
                STT
            </th>
            <th class="text-center" style="width:100px;">Ảnh</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Vai trò</th>
            <th class="text-center">Tình Trạng</th>
        </tr>
        </thead>
        <tbody>
            @if (isset($members) && is_object($members))
                @foreach($members as $index => $member)
                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>
                    <td class="text-center">
                        <span>
                            @if($member->image=="")
                            <img class="image img-cover" src="{{ asset('userfiles\thumb\Images\avata_null.jpg') }}" alt="">
                            @else 
                            <img class="image img-cover" src="{{ asset(Storage::url($member->image)) }}" alt="">
                            @endif
                        </span>
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
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $members->links('pagination::bootstrap-5') }}

</div>
