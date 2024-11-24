@extends('layouts.app')
@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-xl-8 chat">
            <div class="card">
                <input type="hidden" id="idUserReciever" value="{{ $user->id }}">
                <div class="card-header">
                    <div class="d-flex bd-highlight" id="user{{ $user->id }}">
                        <div class="img_cont">
                            @php
                            $checkUrlImg = \Illuminate\Support\Str::contains($user->image, '/userfiles/') ? $user->image : Storage::url($user->image);
                            @endphp
                            @if(isset($user->image))
                            <img src="{{ $checkUrlImg }}" class="rounded-circle user_img">
                            @else
                            <img src="{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="rounded-circle user_img_msg" alt="Profile image">
                            @endif
                            <!-- <span class="online_icon"></span> -->
                        </div>
                        <div class="user_info">
                            <span>{{ $user->name }}</span>
                            <!-- <p class="is_active">Đang hoạt động</p> -->
                        </div>
                    </div>
                    <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                    <div class="action_menu">
                        <ul>
                            <li><i class="fas fa-user-circle"></i> View profile</li>
                            <li><i class="fas fa-users"></i> Add to close friends</li>
                            <li><i class="fas fa-plus"></i> Add to group</li>
                            <li><i class="fas fa-ban"></i> Block</li>
                        </ul>
                    </div>
                </div>
                <div class="card-body msg_card_body">
                    <div class="chat_area_index">
                        <div class="empty-chat-box">
                            <div class="empty-chat-content">
                                <div class="box-content-img">
                                    <img src="{{asset('theme/client/assets/images/logo/Luutru.png')}}" alt="">
                                </div>
                                <div class="icon-wrapper">
                                    <h3 class="empty-chat-title">
                                        <i class="fas fa-comments empty-chat-icon"></i>
                                        Hãy chọn một cuộc trò chuyện
                                    </h3>
                                </div>
                                <p class="empty-chat-message">
                                    <i class="fas fa-hand-point-down"></i>
                                    Nhấp vào để bắt đầu trò chuyện!
                                </p>
                            </div>
                        </div>
                    </div>
                    @foreach ($messagePrivate as $item)
                    @php
                    $checkUrlImg = \Illuminate\Support\Str::contains($item->image_user_send, '/userfiles/') ? $item->image_user_send : Storage::url($item->image_user_send);
                    @endphp
                    @if ($item->id_user_send === Auth::user()->id)
                    <div class="d-flex justify-content-end mb-4">
                        <div class="msg_cotainer_send">
                            {{ isset($item->message) ? $item->message : '' }}
                            <span class="msg_time" data-timestamp="{{ $item->created_at->timestamp }}"></span>
                        </div>
                        <div class="img_cont_msg d-flex align-items-top">
                            @php
                            $checkUrlImg = \Illuminate\Support\Str::contains($item->image_user_send, '/userfiles/') ? $item->image_user_send : Storage::url($item->image_user_send);
                            @endphp
                            @if(isset($item->image_user_send))
                            <img src="{{ $checkUrlImg }}" class="rounded-circle user_img_msg">
                            @else
                            <img src="{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="rounded-circle user_img_msg" alt="Profile image">
                            @endif
                        </div>

                    </div>
                    @else
                    <div class="d-flex justify-content-start mb-4">
                        <div class="img_cont_msg d-flex align-items-top">
                            <a href="{{ url('chat-private/' . $item->id_user_reciever) }}">
                                @php
                                $checkUrlImg = \Illuminate\Support\Str::contains($item->image_user_send, '/userfiles/') ? $item->image_user_send : Storage::url($item->image_user_send);
                                @endphp
                                @if(isset($item->image_user_send))

                                <img src="{{ $checkUrlImg }}" class="rounded-circle user_img_msg">
                                @else
                                <img src="{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="rounded-circle user_img_msg" alt="Profile image">
                                @endif
                            </a>

                        </div>
                        <div class="msg_cotainer">
                            {{ isset($item->message) ? $item->message : '' }}
                            <span class="msg_time msg_time_receiver" data-timestamp="{{ $item->created_at->timestamp }}"></span>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <!-- <div class="input-group-append">
                            <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                        </div> -->
                        <textarea name="" id="content_message" class="form-control type_msg"
                            placeholder="Aa..."></textarea>
                        <div class="input-group-append">
                            <span style=" cursor: default; color: #000;" id="send_message" class="input-group-text send_btn"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    function chatUserInactive(activeUserIds) {
        axios.post('/user-inactive', {
            activeUserIds: activeUserIds
        }).then(res => {
            var card_header_msg_head = document.querySelector('.msg_head');
            var idUserReciever = document.querySelector('#idUserReciever');

            if (idUserReciever) { // Kiểm tra nếu idUserReciever tồn tại
                res.data.inactiveUsers.forEach(user => {
                    if (user.id == idUserReciever.value) { // Kiểm tra nếu idUserReciever trùng với user.id
                        var UI_bd_highlight = `
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="/storage/${user.image ? user.image : 'default-image-path.jpg'}" class="rounded-circle user_img">
                            </div>
                            <div class="user_info">
                                <span style="color: #000">{{ $user->name }}</span>
                            </div>
                        </div>
                    `;
                        card_header_msg_head.insertAdjacentHTML('beforeend', UI_bd_highlight);
                    }
                });
            } else {
                console.error("Không tìm thấy phần tử idUserReciever");
            }
        }).catch(error => {
            console.error("Lỗi khi lấy dữ liệu người dùng không hoạt động:", error);
        });
    }
</script>
<script type="module">
    $(document).ready(function() {
        scrollToBottom()
    })
    Echo.join('chat')
        .here(users => {
            users.forEach(user => {
                console.log(user);

                var userItem = document.querySelector(`#user${user.id}`);
                if (userItem) {
                    var imgCont = userItem.querySelector('.img_cont');
                    var user_info = userItem.querySelector('.user_info');

                    // Tạo và thêm thẻ span và thẻ p
                    var status = document.createElement('span');
                    var is_active = document.createElement('p');
                    status.classList.add('online_icon');
                    is_active.classList.add('is_active');
                    is_active.textContent = 'Đang hoạt động';

                    // Thêm dấu chấm vào imgCont và trạng thái vào user_info
                    imgCont.appendChild(status);
                    user_info.appendChild(is_active);
                }
            });
        })
        .joining(user => {
            var el = document.querySelector(`#user${user.id}`);
            if (el) {
                var img_cont = el.querySelector('.img_cont');
                var user_info = el.querySelector('.user_info');

                if (img_cont) {
                    var el_status = document.createElement('span');
                    el_status.classList.add('online_icon');
                    img_cont.appendChild(el_status);
                }

                if (user_info) {
                    var el_active = document.createElement('p');
                    el_active.classList.add('is_active');
                    el_active.textContent = 'Đang hoạt động';
                    user_info.appendChild(el_active);
                }
            }
        })
        .leaving(user => {
            var el = document.querySelector(`#user${user.id}`);
            if (el) {
                var img_cont = el.querySelector('.img_cont');
                var user_info = el.querySelector('.user_info');

                // Xóa dấu chấm xanh
                var el_status = img_cont.querySelector('.online_icon');
                if (el_status) {
                    img_cont.removeChild(el_status);
                }

                // Xóa trạng thái "Đang hoạt động"
                var el_active = user_info.querySelector('.is_active');
                if (el_active) {
                    user_info.removeChild(el_active);
                }
            }
        });



    var content_message = document.querySelector('#content_message')

    var idUserReciever = document.querySelector('#idUserReciever')
    console.log(idUserReciever);

    var fa_location_arrow = document.createElement('i')
    fa_location_arrow.classList.add('fas', 'fa-location-arrow');

    var send_btn = document.querySelector('.send_btn')

    content_message.addEventListener('input', function() {
        if (content_message.value.trim() == '') {
            if (send_btn.contains(fa_location_arrow)) {
                send_btn.removeChild(fa_location_arrow);
            }
        } else {
            if (!send_btn.contains(fa_location_arrow)) {
                send_btn.appendChild(fa_location_arrow);
                fa_location_arrow.style.cursor = 'pointer'
                fa_location_arrow.style.color = '#000'

            }
        }
    });

    let messageContent = ''

    content_message.addEventListener('keypress', e => {
        if (event.key === 'Enter') {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của phím Enter (nếu có)
            messageContent = content_message.value.trim();
            // Nếu không nhập nội dung
            if (messageContent === '') {
                // Hiển thị Toast nếu không hợp lệ
                Toastify({
                    text: "Nội dung tin nhắn không thể trống!",
                    duration: 3000, // Hiển thị trong 3 giây
                    backgroundColor: "red", // Màu nền đỏ
                    gravity: "top", // Vị trí ở phía trên
                    position: "right" // Vị trí bên phải
                }).showToast();
            } else {
                // Nếu có nội dung, tiếp tục xử lý gửi tin nhắn
                sendMess(messageContent);
            }
        }
    })

    fa_location_arrow.addEventListener('click', function() {

        if (send_btn.contains(fa_location_arrow)) {
            send_btn.removeChild(fa_location_arrow);
        }
        messageContent = content_message.value.trim();
        if (messageContent === '') {
            Toastify({
                text: "Nội dung tin nhắn không thể trống!",
                duration: 3000,
                backgroundColor: "red",
                gravity: "top",
                position: "right"
            }).showToast();
        } else {
            sendMess(messageContent);
        }
    })

    const sendMess = () => {
        axios.post('/message-private', {
                message: messageContent,
                idUserReciever: idUserReciever.value,
            })
            .then(function(response) {
                content_message.value = ''
                scrollToBottom()
            })
    }
</script>
<script type="module">
    function timeSince(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = Math.floor(seconds / 31536000);

        if (interval >= 1) {
            return interval + " năm" + " trước";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) {
            return interval + " tháng" + " trước";
        }
        interval = Math.floor(seconds / 86400);
        if (interval >= 1) {
            return interval + " ngày" + " trước";
        }
        interval = Math.floor(seconds / 3600);
        if (interval >= 1) {
            return interval + " giờ" + " trước";
        }
        interval = Math.floor(seconds / 60);
        if (interval >= 1) {
            return interval + " phút" + " trước";
        }
        return Math.floor(seconds) + " giây" + " trước";
    }

    function updateTimes() {
        var msgTimes = document.querySelectorAll('.msg_time');
        msgTimes.forEach(function(span) {
            const timestamp = span.getAttribute('data-timestamp');
            if (timestamp) {
                const date = new Date(timestamp * 1000);
                span.innerHTML = timeSince(date);
            } else {
                console.error('Timestamp is null for span:', span);
            }
        });
    }

    updateTimes();

    setInterval(updateTimes, 1000);
    Echo.private("chat.private.{{ Auth::user()->id }}.{{ $user->id }}")
        .listen('ChatPrivateEvent', event => {
            console.log(event);

            const currentTimestamp = Math.floor(Date.now() / 1000); // Current time in seconds
            var msg_card_body = document.querySelector('.msg_card_body');
            var card_header_msg_head = document.querySelector('.msg_head');

            let image_url = event.idUserSend?.image ?
                event.idUserSend.image :
                "{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}";

            // Kiểm tra và xử lý đường dẫn ảnh
            let image = image_url.includes('http') ?
                image_url :
                '/storage/' + event.idUserSend?.image || "{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}";

            var ui = ''
            if (event.idUserSend.id == '{{ Auth::user()->id }}') {
                ui = `
                   <div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                   ${event.message}
                                    <span class="msg_time" data-timestamp="${currentTimestamp}"></span>
                                </div>
                                <div class="img_cont_msg">
                                    <img src="${image}"
                                        class="rounded-circle user_img_msg">
                                </div>
                            </div>
              `
            } else {
                ui =
                    `
                     <div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="${image}" class="rounded-circle user_img_msg">
                                </div>
                                <div class="msg_cotainer">
                                   ${event.message}
                                   <span class="msg_time" data-timestamp="${currentTimestamp}"></span>
                                </div>
                            </div> 
                     
                     `
            }


            msg_card_body.insertAdjacentHTML('beforeend', ui)
            updateTimes();
            scrollToBottom()
        })



    Echo.private("chat.private.{{ $user->id }}.{{ Auth::user()->id }}")
        .listen('ChatPrivateEvent', event => {
            var msg_card_body = document.querySelector('.msg_card_body');
            const currentTimestamp = Math.floor(Date.now() / 1000); // Current time in seconds
            var ui = ''
            let image_url = event.idUserSend?.image ?
                event.idUserSend.image :
                "{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}";

            // Kiểm tra và xử lý đường dẫn ảnh
            let image = image_url.includes('http') ?
                image_url :
                '/storage/' + event.idUserSend?.image || "{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}";
            if (event.idUserSend.id == '{{ Auth::user()->id }}') {
                ui = `
                   <div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                   ${event.message}
                                    <span class="msg_time" data-timestamp="${currentTimestamp}"></span>
                                </div>
                                <div class="img_cont_msg">
                                    <img src="/storage/${event.idUserReciever.image}"
                                        class="rounded-circle user_img_msg">
                                </div>
                            </div>
              `
            } else {
                ui =
                    `
                     <div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="${image}" class="rounded-circle user_img_msg">
                                </div>
                                <div class="msg_cotainer">
                                   ${event.message}
                                    <span class="msg_time msg_time_receiver" data-timestamp="${currentTimestamp}"></span>
                                </div>
                            </div> 
                     
                     `
            }

            msg_card_body.insertAdjacentHTML('beforeend', ui)
            updateTimes();
            scrollToBottom()
        })
</script>
<script>
    function scrollToBottom() {
        const chatBox = document.querySelector('.msg_card_body');
        console.log(chatBox);

        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>
@endsection