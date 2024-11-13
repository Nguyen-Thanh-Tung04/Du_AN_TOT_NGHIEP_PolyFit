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
                            @php
                            $checkUrlImg = \Illuminate\Support\Str::contains($item->image, '/userfiles/') ? $item->image : Storage::url($item->image);
                            @endphp
                            <li class="left clearfix">
                                <a style="color: #000" href="{{ url('chat-private-admin/' . $item->id) }}" id="user{{ $item->id }}">
                                    <div class="chat-img pull-left img_cont" style="position: relative;">
                                        @if(isset($item->image))
                                        <img src="{{ $checkUrlImg }}" alt="User Avatar" class="img-circle">
                                        @else
                                        <img src="{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="img-circle" alt="Profile image">
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
                                <img src="{{ $user->image }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;">
                                @else
                                <img src="{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;" alt="Profile image">
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
                                        Hãy chọn một cuộc trò chuyện
                                    </h3>
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
    Echo.join('chat')
        .here(users => {
            console.log(users);

            users.forEach(user => {
                console.log(user.id);

                var userItem = document.querySelector(`#user${user.id}`);
                console.log(userItem);

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
            console.log(el);

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
    const online_icon = document.querySelector('.online_icon')
    const is_active = document.querySelector('.is_active')
    const active = () => {
        online_icon.style.display = "block"
        is_active.style.display = "block"
    }

    const unActive = () => {
        online_icon.style.display = "none"
        is_active.style.display = "none"
    }
</script>

<script>
    var search_text = document.querySelector('.search-text')
    var contacts = document.querySelector('.list-unstyled');
    // console.log(contacts);


    search_text.addEventListener('input', function() {
        var query = search_text.value.trim();


        axios.post('/chat-private-admin/search', {
                search_text: query
            })
            .then(function(response) {

                var ui = '';
                if (response.data && response.data.data) {
                    response.data.data.forEach(function(user) {
                        let image = null
                        if (user.image) {
                            image = 'storage/' + user.image
                        } else {
                            image = 'theme/client/assets/images/whatsapp/admin.jpg'
                        }
                        ui += `
                    <li class="left clearfix">
                            <a style="color: #000" href="{{ url('chat-private-admin/${user.id}') }}" id="user${user.id}">
                                <div class="chat-img pull-left img_cont" style="position: relative;">
                                        <img src="${image}" alt="User Avatar" class="img-circle">
                                    <!-- <span class="online_icon"></span> -->
                                </div>
                                <div class="chat-body clearfix">
                                    <div class="header_sec">
                                        <strong class="primary-font">${user.name}</strong> 
                                        <!-- <strong class="pull-right">
                                            09:45AM</strong> -->
                                    </div>
                                    <div class="user_info" style="position: relative;" >
                                        <!-- <span class="is_active" >Đang hoạt động</span> -->
                                        <p class="activity-time"></p> <!-- Thêm phần tử này để hiển thị giờ online/offline -->
                                    </div>
                                </div>
                            </a>
                    </li>
            `;
                    });
                }
                contacts.innerHTML = ui;
            })
    })
</script>
@endsection