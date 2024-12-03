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
                            <img src="{{ asset('userfiles\thumb\Images\avata_null.jpg') }}" class="rounded-circle user_img_msg" alt="Profile image">
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
                            <img src="{{ asset('userfiles\thumb\Images\avata_null.jpg') }}" class="rounded-circle user_img_msg" alt="Profile image">
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

<script type="module">
    $(document).ready(function() {
        scrollToBottom()
    })
    Echo.join('chat')
        .here(users => {
            users.forEach(user => {
                var userItem = document.querySelector(`#user${user.id}`);
                if (userItem) {
                    var imgCont = userItem.querySelector('.img_cont');
                    var userInfo = userItem.querySelector('.user_info');

                    // Tạo và thêm thẻ span và thẻ p
                    var status = document.createElement('span');
                    var isActive = document.createElement('p');
                    status.classList.add('online_icon');
                    isActive.classList.add('is_active');
                    isActive.textContent = 'Đang hoạt động';

                    imgCont.appendChild(status);
                    userInfo.appendChild(isActive);
                }
            });
        })
        .joining(user => {
            var el = document.querySelector(`#user${user.id}`);
            if (el) {
                var imgCont = el.querySelector('.img_cont');
                var userInfo = el.querySelector('.user_info');

                if (imgCont && !imgCont.querySelector('.online_icon')) {
                    var elStatus = document.createElement('span');
                    elStatus.classList.add('online_icon');
                    imgCont.appendChild(elStatus);
                }

                if (userInfo && !userInfo.querySelector('.is_active')) {
                    var elActive = document.createElement('p');
                    elActive.classList.add('is_active');
                    elActive.textContent = 'Đang hoạt động';
                    userInfo.appendChild(elActive);
                }
            }
        })
        .leaving(user => {
            var el = document.querySelector(`#user${user.id}`);
            if (el) {
                var imgCont = el.querySelector('.img_cont');
                var userInfo = el.querySelector('.user_info');

                var elStatus = imgCont.querySelector('.online_icon');
                if (elStatus) imgCont.removeChild(elStatus);

                var elActive = userInfo.querySelector('.is_active');
                if (elActive) userInfo.removeChild(elActive);
            }
        });

    // Xử lý sự kiện gửi tin nhắn
    var contentMessage = document.querySelector('#content_message');
    var sendBtn = document.querySelector('.send_btn');
    var faLocationArrow = document.createElement('i');
    faLocationArrow.classList.add('fas', 'fa-location-arrow');

    contentMessage.addEventListener('input', function() {
        if (contentMessage.value.trim() === '') {
            sendBtn.removeChild(faLocationArrow);
        } else {
            if (!sendBtn.contains(faLocationArrow)) {
                sendBtn.appendChild(faLocationArrow);
                faLocationArrow.style.cursor = 'pointer';
            }
        }
    });

    faLocationArrow.addEventListener('click', function() {
        let messageContent = contentMessage.value.trim();
        contentMessage.value = '';
        sendBtn.removeChild(faLocationArrow);

        if (messageContent) sendMess(messageContent);
    });

    contentMessage.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            let messageContent = contentMessage.value.trim();
            if (messageContent) {
                sendMess(messageContent);
                contentMessage.value = '';
                sendBtn.removeChild(faLocationArrow);
            }
        }
    });

    function sendMess(messageContent) {
        axios.post('/message-private', {
                message: messageContent,
                idUserReciever: document.querySelector('#idUserReciever').value,
            })
            .then(function(response) {
                scrollToBottom();
            })
            .catch(function(error) {
                console.error('Lỗi khi gửi tin nhắn:', error);
                alert('Không thể gửi tin nhắn. Vui lòng thử lại.');
            });
    }
    function timeSince(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = Math.floor(seconds / 31536000);
        if (interval >= 1) return interval + " năm" + " trước";
        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) return interval + " tháng" + " trước";
        interval = Math.floor(seconds / 86400);
        if (interval >= 1) return interval + " ngày" + " trước";
        interval = Math.floor(seconds / 3600);
        if (interval >= 1) return interval + " giờ" + " trước";
        interval = Math.floor(seconds / 60);
        if (interval >= 1) return interval + " phút" + " trước";
        return Math.floor(seconds) + " giây" + " trước";
    }

    function updateTimes() {
        document.querySelectorAll('.msg_time').forEach(function(span) {
            const timestamp = span.getAttribute('data-timestamp');
            if (timestamp) {
                const date = new Date(timestamp * 1000);
                span.innerHTML = timeSince(date);
            }
        });
    }

    updateTimes();
    setInterval(updateTimes, 1000);
    // Lắng nghe sự kiện tin nhắn
    Echo.private("chat.private.{{ Auth::user()->id }}.{{ $user->id }}")
        .listen('ChatPrivateEvent', event => {
            console.log(event);

            const currentTimestamp = Math.floor(Date.now() / 1000); // Current time in seconds
            var msg_card_body = document.querySelector('.msg_card_body');
            var card_header_msg_head = document.querySelector('.msg_head');

            let image_url = event.idUserSend?.image ?
                event.idUserSend.image :
                "{{ asset('userfiles/thumb/Images/avata_null.jpg') }}";
            // Kiểm tra và xử lý đường dẫn ảnh
            let image = image_url.includes('http') ?
                image_url :
                '/storage/' + event.idUserSend?.image || "{{ asset('userfiles/thumb/Images/avata_null.jpg') }}";

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