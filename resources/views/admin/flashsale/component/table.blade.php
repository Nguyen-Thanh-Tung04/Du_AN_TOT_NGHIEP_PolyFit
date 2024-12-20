<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered table-pagination">
        <thead>
            <tr>
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
                <td class="text-center">{{ $flashSale['time_slot'] }}</td>
                <td class="text-center">{{ $flashSale['product_count'] }}</td>
                <td class="text-center">{{ $flashSale['status'] }}</td>
                <td class="text-center js-switch-{{ $flashSale['id'] }}">
                    <input type="checkbox" value="{{ $flashSale['is_active'] }}"
                        class="js-switch flashsale-status"
                        data-field="status"
                        data-model="FlashSale"
                        data-modelId="{{ $flashSale['id'] }}"
                        {{ ($flashSale['is_active'] == 1) ? 'checked' : '' }}
                        {{ ($flashSale['status'] == "Đã diễn ra") ? 'disabled' : '' }} />
                </td>
                <td class="text-center">
                    <a href="{{ route('flashsale.show', $flashSale['id']) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                    @if ($flashSale['status'] != 'Đã diễn ra')
                    <a href="{{ route('flashsale.edit', $flashSale['id']) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    @endif
                    @if ($flashSale['status'] == 'Sắp diễn ra')
                    <form action="{{ route('flashsale.destroy', $flashSale['id']) }}" method="POST" class="m-0 delete-form" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                    @endif

                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        var tablePagination = $('.table-pagination').DataTable({
            "paging": true,
            "lengthChange": false,
            "pageLength": 10,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            language: {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "Xem _MENU_ mục",
                "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix": "",
                "sSearch": "Tìm:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Đầu",
                    "sPrevious": "Trước",
                    "sNext": "Tiếp",
                    "sLast": "Cuối"
                }
            },
        });

        tablePagination.on('draw', function() {
            $('.js-switch').each(function() {
                if (!$(this).next().hasClass('switchery')) {
                    new Switchery(this, {
                        color: 'rgb(249, 58, 11)',
                        size: 'small'
                    });
                }
            });
        });


        $(document).on('change', '.flashsale-status', function() {
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
        $(document).on('submit', '.delete-form', function(e) {
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