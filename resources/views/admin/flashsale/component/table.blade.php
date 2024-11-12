<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                </th>
                <th class="text-center">Khung giờ</th>
                <th class="text-center">Số sản phẩm tham gia</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Bật/Tắt</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($flashSales) && is_object($flashSales))
            @foreach($flashSales as $flashSale)
            <tr>
                <td>
                    <input type="checkbox" value="{{ $flashSale['id'] }}" class="input-checkbox checkBoxItem">
                </td>
                <td class="text-center">{{ $flashSale['time_slot'] }}</td>
                <td class="text-center">{{ $flashSale['product_count'] }}</td>
                <td class="text-center">{{ $flashSale['status'] }}</td>
                <td class="text-center js-switch-{{ $flashSale['id'] }}">
                    <input type="checkbox" value="{{ $flashSale['is_active'] }}"
                        class="js-switch flashsale-status"
                        data-field="status"
                        data-model="FlashSale"
                        data-modelId="{{ $flashSale['id'] }}"
                        {{ ($flashSale['is_active'] == 1) ? 'checked' : '' }} />
                </td>
                <td class="text-center">
                    <a href="{{ route('flashsale.edit', $flashSale['id']) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <form action="{{ route('flashsale.destroy', $flashSale['id']) }}" method="POST" class="m-0 delete-form" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.flashsale-status').on('change', function() {
            let status = this.checked ? 1 : 0;
            let modelId = $(this).data('modelid');

            $.ajax({
                url: `/flashsale/${modelId}/status`,
                method: 'PATCH',
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });

        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;

            $.ajax({
                url: form.action,
                method: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        $(form).closest('tr').remove();
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
    });
</script>