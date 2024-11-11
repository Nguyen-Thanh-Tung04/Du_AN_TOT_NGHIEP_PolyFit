@extends('layouts.chat-admin')
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
                                    <div class="user_info" style="position: relative;" >
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
            <!--chat_sidebar-->

            <div class="col-sm-9 message_section">
                <div class="row">
                <input type="hidden" id="idUserReciever" value="{{ $user->id }}">
                    <div class="new_message_head">
                        <div class="pull-left" id="user{{ $item->id }}" style="display: flex;">
                            <div class="img_cont" style="position: relative;">
                                <img src="{{ Storage::url($user->image) }}" class="rounded-circle user_img" style="width: 50px; height: 50px; border-radius: 50%;">
                                <!-- <span class="online_icon" style="left: 39px; top: 35px"></span> -->
                            </div>
                            <div class="user_info" style="position: relative;">
                                <span>{{ $user->name }}</span>
                                <!-- <span class="is_active">Đang hoạt động</span> -->
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cogs" aria-hidden="true"></i> Setting
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Profile</a></li>
                                    <li><a href="#">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div><!--new_message_head-->

                    <div class="chat_area msg_card_body">
                        <ul class="list-unstyled">
                        @foreach ($messagePrivate as $item)
                            @if ($item->id_user_send === Auth::user()->id)
                            <li class="left clearfix admin_chat">
                                    @if(isset($item->image_user_send))
                                        <span class="chat-img1 pull-right">
                                        <img src="{{ Storage::url($item->image_user_send) }}" alt="User Avatar" class="img-circle">
                                        </span>
                                    @else
                                        <span class="chat-img1 pull-right">
                                        <img src="{{ asset('theme/client/assets/images/whatsapp/profile_01.jpg') }}" class="img-circle" alt="Profile image">
                                        </span>
                                    @endif

                                    <div class="chat-body1 clearfix">
                                        <p>{{ $item->message }}</p>
                                        <div class="chat_time pull-left">{{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}</div>
                                    </div>
                                </li>

                            @else
                                <li class="left clearfix">
                                    <span class="chat-img1 pull-left">
                                        <img src="{{ Storage::url($item->image_user_send) }}" alt="User Avatar" class="img-circle">
                                    </span>
                                    <div class="chat-body1 clearfix">
                                        <p>{{ $item->message }}</p>
                                        <div class="chat_time pull-right">{{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}</div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                        </ul>
                    </div><!--chat_area-->
                    <div class="message_write" style="position: relative;">
                        <input id="content_message" class="form-control" placeholder="type a message"></input>
                        <div class="clearfix"></div>
                        <div class="chat_bottom">
                                <span class="input-group-text send_btn" style="position: absolute;top: 22px;left: 57vw;"></span>
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

    $(document).ready(function(){
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
        }
    }
});

let messageContent = ''

content_message.addEventListener('keypress',e=>{
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

const sendMess = ()=>{
    axios.post('/message-private', {
            message: messageContent,
            idUserReciever: idUserReciever.value,
        })
        .then(function(response) {
            content_message.value=''
            scrollToBottom()
        })
}
</script>
<script type="module">
function timeSince(date) {
    const seconds = Math.floor((new Date() - date) / 1000);
    let interval = Math.floor(seconds / 31536000);

    if (interval >= 1) {
        return interval + " year" + (interval > 1 ? "s" : "") + " ago";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval >= 1) {
        return interval + " month" + (interval > 1 ? "s" : "") + " ago";
    }
    interval = Math.floor(seconds / 86400);
    if (interval >= 1) {
        return interval + " day" + (interval > 1 ? "s" : "") + " ago";
    }
    interval = Math.floor(seconds / 3600);
    if (interval >= 1) {
        return interval + " hour" + (interval > 1 ? "s" : "") + " ago";
    }
    interval = Math.floor(seconds / 60);
    if (interval >= 1) {
        return interval + " minute" + (interval > 1 ? "s" : "") + " ago";
    }
    return Math.floor(seconds) + " second" + (seconds > 1 ? "s" : "") + " ago";
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
        var card_header_msg_head = document.querySelector('.msg_head')
        var UI_bd_highlight = `
                <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    <img src="storage/${event.idUserReciever.image}"
                                        class="rounded-circle user_img">
                                    <span class="online_icon"></span>
                                </div>
                                <div class="user_info">
                                    <span>${event.idUserReciever.name}</span>
                                    <p>Hoạt động 45 phút trước</p>
                                </div>
                            </div>
                `
        var ui = ''
        if (event.idUserSend.id == '{{ Auth::user()->id }}') {
            ui = `
                    <li class="left clearfix admin_chat">
                        <span class="chat-img1 pull-right">
                            <img src="/storage/${event.idUserSend.image}" alt="User Avatar" class="img-circle">
                        </span>
                        <div class="chat-body1 clearfix">
                            <p>${event.message}</p>
                            <div class="chat_time pull-right">${currentTimestamp}</div>
                        </div>
                    </li>

              `
        } else {
            ui =
                `
                    <li class="left clearfix">
                        <span class="chat-img1 pull-left">
                            <img src="/storage/${event.idUserSend.image}" alt="User Avatar" class="img-circle">
                        </span>
                        <div class="chat-body1 clearfix">
                            <p>${event.message}</p>
                            <div class="chat_time pull-right">${currentTimestamp}</div>
                        </div>
                    </li>
                     
                     `
        }


        msg_card_body.insertAdjacentHTML('beforeend', ui)
        updateTimes();
    })



Echo.private("chat.private.{{ $user->id }}.{{ Auth::user()->id }}")
    .listen('ChatPrivateEvent', event => {
        var msg_card_body = document.querySelector('.msg_card_body');
        const currentTimestamp = Math.floor(Date.now() / 1000); // Current time in seconds
        var ui = ''
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
                    <li class="left clearfix admin_chat">
                        <span class="chat-img1 pull-right">
                            <img src="/storage/${event.idUserSend.image} alt="User Avatar" class="img-circle">
                        </span>
                        <div class="chat-body1 clearfix">
                            <p>${event.message}</p>
                            <div class="chat_time pull-left">${currentTimestamp}</div>
                        </div>
                    </li>              
                     `
        }

        msg_card_body.insertAdjacentHTML('beforeend', ui)
        updateTimes();
    })
    
</script>
    Route::post('/chat-private-admin/search',[ChatController::class,'search']);

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
                    ui += `
                    <li class="left clearfix">
                            <a style="color: #000" href="{{ url('chat-private-admin/${user.id}') }}" id="user${user.id}">
                                <div class="chat-img pull-left img_cont" style="position: relative;">
                                    @if(isset($item->image))
                                        <img src="storage/${user.image}" alt="User Avatar" class="img-circle">
                                    @else
                                        <img src="{{ asset('theme/client/assets/images/whatsapp/profile_01.jpg') }}" class="img-circle" alt="Profile image">
                                    @endif
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

function scrollToBottom() {
    const chatBox = document.querySelector('.msg_card_body');
    console.log(chatBox);
    
    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>
@endsection