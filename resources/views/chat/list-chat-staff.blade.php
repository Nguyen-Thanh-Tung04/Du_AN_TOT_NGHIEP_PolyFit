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
                            $checkUrlImg = \Illuminate\Support\Str::contains($item->user_image, '/userfiles/') ? $item->user_image : Storage::url($item->user_image);
                            @endphp
                            <li class="left clearfix">
                                <a style="color: #000" href="{{ url('chat-private-admin/' . $item->user_id) }}" id="user{{ $item->user_id }}">
                                    <div class="chat-img pull-left img_cont" style="position: relative;">
                                        @if(isset($item->user_image))
                                        <img src="{{ $checkUrlImg }}" alt="User Avatar" class="img-circle">
                                        @else
                                        <img src="{{asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="img-circle" alt="Profile image">
                                        @endif
                                        <!-- Dấu chấm xanh (hoặc trạng thái online) sẽ được thêm vào đây -->
                                    </div>
                                    <div class="chat-body clearfix">
                                        <div class="header_sec">
                                            <strong class="primary-font">{{ $item->user_name }}</strong>
                                            <p class="pull-right">{{ $item->created_at->format('h:i A') }}</p>
                                        </div>
                                        <div class="user_info" style="position: relative;">
                                            <span class="is_active" style="display: none;">Đang hoạt động</span> <!-- Thêm phần tử này để hiển thị giờ online/offline -->
                                            <p class="activity-time"></p>
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
                        <div class="pull-left" id="user{{ $item->id ?? '' }}" style="display: flex;">
                            <div class="img_cont">
                                @if(isset($user->image))
                                <img src="{{ $user->image }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;">
                                @else
                                <img src="{{ asset('userfiles\thumb\Images\avata_null.jpg') }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;" alt="Profile image">
                                @endif
                                <span class="online_icon" style="left: 50px; top: 51px; display: block;"></span>
                            </div>
                            <div class="user_info" style="position: relative;">
                                <span>{{ $user->name }}</span>
                                <p class="is_active2">Đang hoạt động</p>
                            </div>
                            
                        </div>
                        <div class="pull-right">
                                <a href="{{ route('list-chat') }}">
                                <button type="button">
                                    <i class="fa fa-cogs"></i> Quay lại
                                    <span class="caret"></span>
                                </button>
                                </a>
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
                                    Nhấp vào tên nhân viên ở bên trái để bắt đầu trò chuyện!
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
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script type="module">
    Echo.join('chat')
        .here(users => {
            users.forEach(user => {
                var userItem = document.querySelector(`#user${user.id}`);
                if (userItem) {
                    var imgCont = userItem.querySelector('.img_cont');
                    var userInfo = userItem.querySelector('.user_info');

                    // Tạo và thêm thẻ span cho dấu chấm xanh (online)
                    var status = document.createElement('span');
                    status.classList.add('online_icon');
                    imgCont.appendChild(status);  // Thêm dấu chấm xanh vào imgCont
                    
                    // Cập nhật trạng thái hoạt động
                    var isActive = userInfo.querySelector('.is_active');
                    if (isActive) {
                        isActive.style.display = 'block';  // Hiển thị trạng thái đang hoạt động
                    }
                }
            });
        })
        .joining(user => {
            var el = document.querySelector(`#user${user.id}`);
            if (el) {
                var imgCont = el.querySelector('.img_cont');
                var userInfo = el.querySelector('.user_info');

                // Thêm dấu chấm xanh khi người dùng tham gia
                var elStatus = document.createElement('span');
                elStatus.classList.add('online_icon');
                imgCont.appendChild(elStatus);

                // Hiển thị trạng thái đang hoạt động
                var elActive = userInfo.querySelector('.is_active');
                if (elActive) {
                    elActive.style.display = 'block';
                }
            }
        })
        .leaving(user => {
            var el = document.querySelector(`#user${user.id}`);
            if (el) {
                var imgCont = el.querySelector('.img_cont');
                var userInfo = el.querySelector('.user_info');

                // Xóa dấu chấm xanh khi người dùng rời đi
                var elStatus = imgCont.querySelector('.online_icon');
                if (elStatus) {
                    imgCont.removeChild(elStatus);
                }

                // Ẩn trạng thái đang hoạt động
                var elActive = userInfo.querySelector('.is_active');
                if (elActive) {
                    elActive.style.display = 'none';
                }
            }
        });
</script>

<script>
    var search_text = document.querySelector('.search-text')
    var contacts = document.querySelector('.list-unstyled')


    search_text.addEventListener('input', function() {
        var query = search_text.value.trim();


        axios.post('/chat-private-admin/search', {
                search_text: query
            })
            .then(function(response) {

                var ui = '';
                if (response.data && response.data.data) {
                    console.log(response.data.data);

                    response.data.data.forEach(function(user) {
                        let image = null
                        if (user.user_image) {
                            image = 'storage/' + user.user_image
                        } else {
                            image = 'userfiles\thumb\Images\avata_null.jpg'
                        }
                        ui += `
                        <li class="left clearfix">
                                <a style="color: #000" href="/chat-private-admin/${user.user_id}" id="user${user.user_id}">
                                    <div class="chat-img pull-left img_cont" style="position: relative;">
                                        <img src="${image}" alt="User Avatar" class="img-circle">
                                    </div>
                                    <div class="chat-body clearfix">
                                        <div class="header_sec">
                                            <strong class="primary-font">${user.user_name}</strong>
                                            <p class="pull-right">${new Date(user.latest_message_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}</p>
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