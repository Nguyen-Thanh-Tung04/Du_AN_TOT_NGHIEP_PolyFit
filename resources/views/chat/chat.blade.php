@extends('admin.layout')
@section('content')
<div class="main_section">
    <div class="container-fluid">
        <div class="chat_container">
            <div class="col-sm-3 chat_sidebar">
                <div class="row">
                    <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="text" placeholder="Search..." name="" class="form-control search search-text">

                            <button class="btn btn-danger" type="button">
                                <span class="glyphicon glyphicon-search search_btn"></span>
                            </button>
                        </div>
                    </div>
                    <div class="member_list">
                        <ul class="list-unstyled">
                            @foreach($users as $item)

                            <li class="left clearfix">
                                <a style="color: #000" href="{{ url('chat-private-admin/' . $item->id) }}" id="user{{ $item->id }}">
                                    <div class="chat-img pull-left img_cont" style="position: relative;">
                                        @if(isset($item->image))
                                        <img src="{{ Storage::url($item->image) }}" alt="User Avatar" class="img-circle">
                                        @else
                                        <img src="{{ asset('theme/client/assets/images/whatsapp/profile_01.jpg') }}" class="img-circle" alt="Profile image">
                                        @endif
                                        <!-- <span class="online_icon"></span> -->
                                    </div>
                                    <div class="chat-body clearfix">
                                        <div class="header_sec">
                                            <strong class="primary-font">{{ $item->name }}</strong>
                                            <!-- <strong class="pull-right">
                                            09:45AM</strong> -->
                                        </div>
                                        <div class="user_info" style="position: relative;">
                                            <!-- <span class="is_active" >Đang hoạt động</span> -->
                                            <p class="activity-time"></p> <!-- Thêm phần tử này để hiển thị giờ online/offline -->
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 message_section">
                <div class="row">
                    <div class="new_message_head">
                        <div class="pull-left" id="user{{ $item->id }}" style="display: flex;">
                            <div class="img_cont">
                                @if(isset($user->image))
                                <img src="{{ Storage::url($user->image) }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;">
                                @else
                                <img src="{{ asset('theme/client/assets/images/whatsapp/profile_01.jpg') }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;" alt="Profile image">
                                @endif
                                <span class="online_icon2 online_icon" style="left: 50px; top: 51px; display: block;"></span>
                            </div>
                            <div class="user_info" style="position: relative;">
                                <span>{{ $user->name }}</span>
                                <p class="is_active2">Đang hoạt động</p>
                            </div>
                        </div>

                    </div><!--new_message_head-->
                    <div class="chat_area_index">
                        <div class="empty-chat-box">
                            <div class="empty-chat-content">
                                <div class="box-content-img">
                                    <img src="admin/img/Luutru.png" alt="">
                                </div>
                                <div class="icon-wrapper">
                                    <h3 class="empty-chat-title">
                                        <i class="fas fa-comments empty-chat-icon"></i>
                                        Hãy chọn một cuộc trò chuyện</h3>
                                </div>
                                <p class="empty-chat-message">
                                    <i class="fas fa-hand-point-left"></i> 
                                    Nhấp vào tên người dùng ở bên trái để bắt đầu trò chuyện!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="message_write" style="position: relative;">
                        <input id="content_message" class="form-control" placeholder="type a message"></input>
                        <div class="clearfix"></div>
                        <div class="chat_bottom">
                            <span class="input-group-text send_btn" style="position: absolute;top: 25px;left: 57vw;"><i class="fas fa-location-arrow"></i></span>
                        </div>
                    </div>
                </div>
            </div> <!--message_section-->
            <!--chat_sidebar-->


        </div>
    </div>
</div>

@endsection
@section('js')

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

                    // active()
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
                // active()
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

                // unActive()
            }
        });

    // const online_icon2 = document.querySelector('.online_icon2')
    // const is_active2 = document.querySelector('.is_active2')
    // const active = () => {
    //     online_icon2.style.display = "block"
    //     is_active2.style.display = "block"
    // }

    // const unActive = () => {
    //     online_icon2.style.display = "none"
    //     is_active2.style.display = "none"
    // }

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
            }
        }
    });

    let messageContent = ''

    content_message.addEventListener('keypress', e => {
        if (event.key === 'Enter') {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của phím Enter (nếu có)
            messageContent = content_message.value.trim();
            sendMess();
        }
    })

    fa_location_arrow.addEventListener('click', function() {

        if (send_btn.contains(fa_location_arrow)) {
            send_btn.removeChild(fa_location_arrow);
        }
        messageContent = content_message.value.trim();
        sendMess()
        // axios.post('/message-private', {
        //         message: messageContent,
        //         idUserReciever: idUserReciever.value,
        //     })
        //     .then(function(response) {

        //     })
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