@extends('admin.layout')
@section('content')
<div class="main_section">
    <div class="container-fluid">
        @if(Auth::user()->user_catalogue_id == 1)
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>Quản lý tin nhắn</h2>
                <ol class="breadcrumb" style="margin-bottom: 10px;">
                    <li>
                        <a href="{{ route('dashboard.index') }}">Dashboard</a>
                    </li>
                    <li class="active"><strong>Danh sách tin nhắn</strong></li>
                </ol>
            </div>
        </div>
        <div class="row mt-20">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Danh sách tin nhắn</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="#"
                                        class="changeStatusAll"
                                        data-field="publish"
                                        data-model="Category"
                                        data-value="1">Active toàn bộ</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="changeStatusAll"
                                        data-field="publish"
                                        data-model="Category"
                                        data-value="2">UnActive toàn bộ</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>

                    </div>
                    <div class="ibox-content">
                        <form action="">
                            <div class="filter-wraper">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    @php
                                    $perpage = request('perpage') ?: old('perpage');
                                    $publish = request('publish') ?: old('publish');
                                    $discount_type = request('discount_type') ?: old('discount_type');
                                    @endphp
                                    <!-- Bộ lọc số lượng bản ghi hiển thị -->
                                    <div class="perpage">
                                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                            <select name="perpage" class="form-control input-control input-sm perpage filter mr-10">
                                                @for($i = 20; $i <= 200; $i+=20)
                                                    <option {{ ($perpage == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }} bản ghi</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Bộ lọc trạng thái -->
                                    <div class="action">
                                        <div class="uk-flex uk-flex-middle">
                                            <select name="publish" class="form-control mr-10 setupSelect2">
                                                @foreach (config('apps.general.publish') as $key => $val)
                                                <option {{ ($publish == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                                                @endforeach
                                            </select>

                                            <!-- Tìm kiếm từ khóa -->
                                            <div class="uk-search uk-flex uk-flex-middle ml-10">
                                                <div class="input-group" style="display: flex; margin-right: 10px;">
                                                    <input type="text"
                                                        name="keyword"
                                                        value="{{ request('keyword') ?: old('keyword') }}"
                                                        placeholder="Nhập từ khóa bạn muốn tìm kiếm..."
                                                        class="form-control" style="width: 200px">

                                                    <button type="submit" name="search" value="search" class="btn btn-success mb0 btn-sm">
                                                        Tìm kiếm
                                                    </button>
                                                </div>
                                                <a href="{{ route('list-chat-staff') }}" class="btn btn-danger"><i class="fa fa-comment"></i> Chat với nhân viên</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            STT
                                        </th>
                                        <th class="text-center">Khách hàng</th>
                                        <th class="text-center">Nhân viên phụ trách</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Thời gian cuối cùng</th>
                                        <th class="text-center">Tin nhắn mới nhất</th>
                                        <th class="text-center">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $user->sender_name }}</td>
                                        <td class="text-center">{{ $user->receiver_name }}</td>
                                        <td class="text-center">
                                            @if ($user->is_read == 1)
                                            <span class="badge bg-success">Đã xem</span>
                                            @else
                                            <span class="badge bg-danger">Chưa xem</span>
                                            @endif
                                        </td>

                                        <td class="text-center">{{ $user->created_at }}</td>
                                        <td class="text-center">{{ $user->message }}</td>

                                        <td class="text-center">
                                            <button type="button" id="show-btn"
                                                data-toggle="modal"
                                                data-target="#detailModal"
                                                class="btn btn-primary"
                                                data-sender_id="{{ $user->sender_id }}"
                                                data-receiver_id="{{ $user->receiver_id }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="col-sm-12 message_section" id="modal-body-container">

                    </div>
                </div>
            </div>
        </div>

        @else
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
                                        <img src="{{ asset('userfiles\thumb\Images\avata_null.jpg') }}"
                                            class="img-circle" alt="Profile image">
                                        @endif
                                        <!-- <span class="online_icon"></span> -->
                                    </div>
                                    <div class="chat-body clearfix">
                                        <div class="header_sec">
                                            <strong class="primary-font">{{ $item->user_name }}</strong>
                                            <p class="pull-right">{{ $item->created_at->format('h:i A') }}</p>
                                        </div>
                                        <div class="user_info" style="position: relative;">
                                            @if($item->is_read === 0)
                                            <strong class="is_active">{{ $item->message }}</strong>
                                            @else
                                            <span class="is_active">{{ $item->message }}</span>
                                            @endif
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
                        <div class="pull-left" id="user{{ $item->id ?? '' }}" style="display: flex;">
                            <div class="img_cont">
                                @if(isset($user->image))
                                <img src="{{ $user->image }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;">
                                @else
                                <img src="{{asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;" alt="Profile image">
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
        </div>
        @endif

    </div>
</div>
@endsection
@section('js')
<script>
    $(document).on('click', '#show-btn', function() {
        var sender_id = $(this).data('sender_id');
        var receiver_id = $(this).data('receiver_id');
        console.log(sender_id);
        console.log(receiver_id);

        $.ajax({
            url: '/show-chat/' + sender_id + '/' + receiver_id,
            method: 'GET',
            success: function(response) {
                console.log('Success', response);
                var receiver_id = response.messagePrivate[0]?.receiver_id;
                var chatLink = "{{ route('chat-private-admin', ['idUser' => '__receiver_id__']) }}".replace('__receiver_id__', receiver_id);
                console.log(chatLink);
                // Duyệt qua danh sách tin nhắn từ response.messagePrivate
                let messagesHtml = '';
                response.messagePrivate.forEach(item => {

                    const isSender = item.sender_id === sender_id; // Kiểm tra tin nhắn do ai gửi
                    const imageUrl = item.sender_image ? `storage/${item.sender_image}`: '{{ asset("userfiles/thumb/Images/avata_null.jpg") }}';

                    messagesHtml += `
                        <li class="${isSender ? 'left clearfix' : 'left clearfix admin_chat'}">
                            <span class="chat-img1 ${isSender ? 'pull-left' : 'pull-right'}">
                                <img src="${imageUrl}" alt="User Avatar" class="img-circle">
                            </span>
                            <div class="chat-body1 clearfix">
                                <p>${item.message}</p>
                                <div class="chat_time ${isSender ? 'pull-left' : 'pull-right'}"> ${new Date(item.created_at).toLocaleString()}</div>
                            </div>
                        </li>
                    `;
                });
                // Nội dung HTML
                const htmlContent = `
                    <div class="row">
                        <input type="hidden" id="idUserReciever" value="${receiver_id}">
                        <div class="new_message_head">
                            <div class="pull-left" id="" style="display: flex;">
                                <div class="img_cont">
                                    <img src="storage/${response.messagePrivate[0]?.sender_image || '{{ asset("userfiles/thumb/Images/avata_null.jpg") }}'}" class="rounded-circle user_img" style="width: 50px; height: 50px;" alt="Profile image">
                                    <span class="online_icon2 online_icon" style="left: 50px; top: 51px;"></span>
                                </div>
                                <div class="user_info" style="position: relative;">
                                    <span id="employeeName">Khách hàng: ${response.messagePrivate[0]?.sender_name || 'Không rõ'}</span>
                                    <p class="is_active2">Đang hoạt động</p>
                                </div>
                            </div>
                            <div class="pull-right" style="display: flex;">
                                <div class="user_info" style="position: relative;">
                                    <span id="employeeName" style="direction: rtl;">Nhân viên: ${response.messagePrivate[0]?.receiver_name || 'Không rõ'}</span>
                                    <p class="is_active2" style="direction: rtl;">Đang hoạt động</p>
                                </div>
                                <div class="img_cont" style="position: relative;">
                                    <img src="${response.messagePrivate[0]?.receiver_image || '{{ asset("userfiles/thumb/Images/avata_null.jpg") }}'}" class="rounded-circle user_img" style="width: 50px; height: 50px;" alt="Profile image">
                                    <span class="online_icon2 online_icon" style="left: 5px; top: 35px;"></span>
                                </div>
                            </div>
                        </div><!--new_message_head-->

                        <div class="chat_area msg_card_body" style="background-color:rgb(255, 255, 255);">
                            <ul class="list-unstyled">
                                ${messagesHtml}
                            </ul>
                        </div><!--chat_area-->

                        <div class="message_write" style="text-align: center;">
                            <div class="chat_bottom">
                                <a href="${chatLink}" id="chat-link">
                                    <button class="btn btn-primary send_btn"><i class="fa fa-comment"></i> Chat với nhân viên</button>
                                </a>
                            </div>
                        </div>
                    </div>
                `;

                // Đổ HTML vào modal-body
                $('#modal-body-container').html(htmlContent);
            },
            error: function(xhr) {
                alert('Không tìm thấy chuyên ngành');
            }
        });
    });
</script>

<script type="module">
    Echo.join('chat')
        .here(users => {
            users.forEach(user => {
                var userItem = document.querySelector(`#user${user.id}`);

                if (userItem) {
                    var imgCont = userItem.querySelector('.img_cont');
                    // var user_info = userItem.querySelector('.user_info');

                    // Tạo và thêm thẻ span và thẻ p
                    var status = document.createElement('span');
                    // var is_active = document.createElement('p');
                    status.classList.add('online_icon');
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