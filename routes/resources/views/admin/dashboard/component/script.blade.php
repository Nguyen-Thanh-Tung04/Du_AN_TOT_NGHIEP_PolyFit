

    <script src="admin/js/bootstrap.min.js"></script>
    <script src="admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="admin/library/library.js"></script>
    <script src="admin/plugins/jquery-ui.js"></script>


    <!-- Custom and plugin javascript -->
    <script src="admin/js/inspinia.js"></script>
    <script src="admin/js/plugins/pace/pace.min.js"></script>

    <script src="admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- jQuery UI -->
    <script src="admin/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="admin/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="admin/js/plugins/dataTables/datatables.min.js"></script>

    @if (isset($config['js']) && is_array($config['js']))
        @foreach ($config['js'] as $key => $val)
            {!! '<script src="'.$val.'"></script>' !!}
        @endforeach
    @endif


    <!-- Toastr script -->
    <script src="admin/js/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">
        $(function () {
            var i = -1;
            var toastCount = 0;
            var $toastlast;
            var getMessage = function () {
                var msg = 'Hi, welcome to Inspinia. This is example of Toastr notification box.';
                return msg;
            };

            $('#showsimple').click(function (){
                // Display a success toast, with a title
                toastr.success('Without any options','Simple notification!')
            });
            $('#showtoast').click(function () {
                var shortCutFunction = $("#toastTypeGroup input:radio:checked").val();
                var msg = $('#message').val();
                var title = $('#title').val() || '';
                var $showDuration = $('#showDuration');
                var $hideDuration = $('#hideDuration');
                var $timeOut = $('#timeOut');
                var $extendedTimeOut = $('#extendedTimeOut');
                var $showEasing = $('#showEasing');
                var $hideEasing = $('#hideEasing');
                var $showMethod = $('#showMethod');
                var $hideMethod = $('#hideMethod');
                var toastIndex = toastCount++;
                toastr.options = {
                    closeButton: $('#closeButton').prop('checked'),
                    debug: $('#debugInfo').prop('checked'),
                    progressBar: $('#progressBar').prop('checked'),
                    preventDuplicates: $('#preventDuplicates').prop('checked'),
                    positionClass: $('#positionGroup input:radio:checked').val() || 'toast-top-right',
                    onclick: null
                };
                if ($('#addBehaviorOnToastClick').prop('checked')) {
                    toastr.options.onclick = function () {
                        alert('You can perform some custom action after a toast goes away');
                    };
                }
                if ($showDuration.val().length) {
                    toastr.options.showDuration = $showDuration.val();
                }
                if ($hideDuration.val().length) {
                    toastr.options.hideDuration = $hideDuration.val();
                }
                if ($timeOut.val().length) {
                    toastr.options.timeOut = $timeOut.val();
                }
                if ($extendedTimeOut.val().length) {
                    toastr.options.extendedTimeOut = $extendedTimeOut.val();
                }
                if ($showEasing.val().length) {
                    toastr.options.showEasing = $showEasing.val();
                }
                if ($hideEasing.val().length) {
                    toastr.options.hideEasing = $hideEasing.val();
                }
                if ($showMethod.val().length) {
                    toastr.options.showMethod = $showMethod.val();
                }
                if ($hideMethod.val().length) {
                    toastr.options.hideMethod = $hideMethod.val();
                }
                if (!msg) {
                    msg = getMessage();
                }
                $("#toastrOptions").text("Command: toastr["
                    + shortCutFunction
                    + "](\""
                    + msg
                    + (title ? "\", \"" + title : '')
                    + "\")\n\ntoastr.options = "
                    + JSON.stringify(toastr.options, null, 2)
                );
                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                $toastlast = $toast;
                if ($toast.find('#okBtn').length) {
                    $toast.delegate('#okBtn', 'click', function () {
                        alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
                        $toast.remove();
                    });
                }
                if ($toast.find('#surpriseBtn').length) {
                    $toast.delegate('#surpriseBtn', 'click', function () {
                        alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
                    });
                }
            });
            function getLastToast(){
                return $toastlast;
            }
            $('#clearlasttoast').click(function () {
                toastr.clear(getLastToast());
            });
            $('#cleartoasts').click(function () {
                toastr.clear();
            });
        })
    </script>
<script>
// Hàm cập nhật số lượng tin nhắn chưa đọc
const updateUnreadMessagesCount = () => {
    $.ajax({
        url: '/get-unread-messages-count',  // API lấy số lượng tin nhắn chưa đọc
        type: 'GET',
        success: function(response) {
            // Cập nhật số lượng tin nhắn chưa đọc vào giao diện
            $('#unreadMessagesCount').text(response.unreadCount);
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy số lượng tin nhắn chưa đọc:', error);
        }
    });
};

// Gọi hàm khi trang tải lần đầu tiên để hiển thị số lượng tin nhắn chưa đọc
$(document).ready(function() {
    updateUnreadMessagesCount();  // Cập nhật ngay khi trang tải

    // Kiểm tra mỗi 5 giây (5000ms)
    setInterval(function() {
        updateUnreadMessagesCount();
    }, 5000);  // 5 giây
});


</script>
