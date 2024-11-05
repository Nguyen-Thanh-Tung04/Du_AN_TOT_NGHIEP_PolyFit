
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
	<head>
		<title>Chat</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
		body,html{
			height: 100%;
			margin: 0;
			background: #7F7FD5;
	        background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
	        background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
		}

		.chat{
			margin-top: auto;
			margin-bottom: auto;
		}
		.card{
			height: 500px;
			border-radius: 15px !important;
			background-color: rgba(0,0,0,0.4) !important;
		}
		.contacts_body{
			padding:  0.75rem 0 !important;
			overflow-y: auto;
			white-space: nowrap;
		}
		.msg_card_body{
			overflow-y: auto;
		}
		.card-header{
			border-radius: 15px 15px 0 0 !important;
			border-bottom: 0 !important;
		}
	 .card-footer{
		border-radius: 0 0 15px 15px !important;
			border-top: 0 !important;
	}
		.container{
			align-content: center;
		}
		.search{
			border-radius: 15px 0 0 15px !important;
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color:white !important;
		}
		.search:focus{
		     box-shadow:none !important;
           outline:0px !important;
		}
		.type_msg{
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color:white !important;
			height: 60px !important;
			overflow-y: auto;
		}
			.type_msg:focus{
		     box-shadow:none !important;
           outline:0px !important;
		}
		.attach_btn{
	border-radius: 15px 0 0 15px !important;
	background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.send_btn{
	border-radius: 0 15px 15px 0 !important;
	background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.search_btn{
			border-radius: 0 15px 15px 0 !important;
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.contacts{
			list-style: none;
			padding: 0;
		}
		.contacts li{
			width: 100% !important;
			padding: 5px 10px;
			margin-bottom: 15px !important;
		}
	.active{
			background-color: rgba(0,0,0,0.3);
	}
		.user_img{
			height: 70px;
			width: 70px;
			border:1.5px solid #f5f6fa;
		
		}
		.user_img_msg{
			height: 40px;
			width: 40px;
			border:1.5px solid #f5f6fa;
		
		}
	.img_cont{
			position: relative;
			height: 70px;
			width: 70px;
	}
	.img_cont_msg{
			height: 40px;
			width: 40px;
	}
	.online_icon{
		position: absolute;
		height: 15px;
		width:15px;
		background-color: #4cd137;
		border-radius: 50%;
		bottom: 0.2em;
		right: 0.4em;
		border:1.5px solid white;
	}
	.offline{
		background-color: #c23616 !important;
	}
	.user_info{
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 15px;
	}
	.user_info span{
		font-size: 20px;
		color: white;
	}
	.user_info p{
	font-size: 10px;
	color: rgba(255,255,255,0.6);
	}
	.video_cam{
		margin-left: 50px;
		margin-top: 5px;
	}
	.video_cam span{
		color: white;
		font-size: 20px;
		cursor: pointer;
		margin-right: 20px;
	}
	.msg_cotainer{
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 10px;
		border-radius: 25px;
		background-color: #82ccdd;
		padding: 10px;
		position: relative;
	}
	.msg_cotainer_send{
		margin-top: auto;
		margin-bottom: auto;
		margin-right: 10px;
		border-radius: 25px;
		background-color: #78e08f;
		padding: 10px;
		position: relative;
	}
	.msg_time{
		position: absolute;
		left: 0;
		bottom: -15px;
		color: rgba(255,255,255,0.5);
		font-size: 10px;
	}
	.msg_time_send{
		position: absolute;
		right:0;
		bottom: -15px;
		color: rgba(255,255,255,0.5);
		font-size: 10px;
	}
	.msg_head{
		position: relative;
	}
	#action_menu_btn{
		position: absolute;
		right: 10px;
		top: 10px;
		color: white;
		cursor: pointer;
		font-size: 20px;
	}
	.action_menu{
		z-index: 1;
		position: absolute;
		padding: 15px 0;
		background-color: rgba(0,0,0,0.5);
		color: white;
		border-radius: 15px;
		top: 30px;
		right: 15px;
		display: none;
	}
	.action_menu ul{
		list-style: none;
		padding: 0;
	margin: 0;
	}
	.action_menu ul li{
		width: 100%;
		padding: 10px 15px;
		margin-bottom: 5px;
	}
	.action_menu ul li i{
		padding-right: 10px;
	
	}
	.action_menu ul li:hover{
		cursor: pointer;
		background-color: rgba(0,0,0,0.2);
	}
	@media(max-width: 576px){
	.contacts_card{
		margin-bottom: 15px !important;
	}
	}
		</style>
	</head>
	
	<!--Coded With Love By Mutiullah Samim-->
	<body>
	<div class="container">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100">
                <div class="col-md-4 col-xl-3 chat">
                    <div class="card mb-sm-3 mb-md-0 contacts_card">
                        <div class="card-header">
                            <div class="input-group">
                                <input type="text" placeholder="Search..." name=""
                                    class="form-control search search-text">
                                <div class="input-group-prepend">
                                    <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body contacts_body">
                            <ui class="contacts">

                                @foreach ($users as $item)
                                    <li class="{{ $item->id == $user->id ? 'active' : '' }}">
                                        <a href="{{ url('chat-private/' . $item->id) }}" id="user{{ $item->id }}">
                                            <div class="d-flex bd-highlight">
                                                <div class="img_cont">
                                                    <img src="{{ $item->image }}" class="rounded-circle user_img">

                                                    {{-- <span class="online_icon"></span> --}}
                                                </div>

                                                <div class="user_info">
                                                    <span>{{ $item->name }}</span>
                                                </div>


                                            </div>
                                        </a>

                                    </li>
                                @endforeach


                            </ui>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
                <div class="col-md-8 col-xl-6 chat">
                    <div class="card">
                        <input type="hidden" id="idUserReciever" value="{{ $user->id }}">
                        <div class="card-header msg_head">

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

                            @foreach ($messagePrivate as $item)
                                @if ($item->id_user_send == Auth::user()->id)
                                    <div class="d-flex justify-content-end mb-4">
                                        <div class="msg_cotainer_send">
                                            {{ $item->message }}
                                            <span class="msg_time"
                                                data-timestamp="{{ $item->created_at->timestamp }}"></span>
                                        </div>
                                        <div class="img_cont_msg">
                                            <img src="{{ $item->image_user_send }}" class="rounded-circle user_img_msg">
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-start mb-4">
                                        <div class="img_cont_msg">
                                            <a href="{{ url('chat-private/' . $item->id_user_reciever) }}">
                                                <img src="{{ $item->image_user_reciever }}"
                                                    class="rounded-circle user_img_msg">
                                            </a>

                                        </div>
                                        <div class="msg_cotainer">
                                            {{ $item->message }}
                                            <span class="msg_time"
                                                data-timestamp="{{ $item->created_at->timestamp }}"></span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach


                        </div>
                        <div class="card-footer">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
								</div>
								<textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
								<div class="input-group-append">
									<span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script>
        function chatUserInactive(activeUserIds) {
            axios.post('/user-inactive', {
                activeUserIds: activeUserIds
            }).then(res => {
                var card_header_msg_head = document.querySelector('.msg_head');
                var idUserReciever = document.querySelector('#idUserReciever');

                // Clear any previous content
                // card_header_msg_head.innerHTML = '';

                // Loop through each inactive user
                res.data.inactiveUsers.forEach(user => {
                    if (user.id == idUserReciever
                        .value) { // Uncomment this line if you want to filter by idUserReciever
                        var UI_bd_highlight = `
                    <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <img src="${user.image || 'default-image-path.jpg'}" class="rounded-circle user_img">
                        </div>
                        <div class="user_info">
                            <span>${user.name}</span>
                        </div>
                        <div class="video_cam">
                            <span><i class="fas fa-video"></i></span>
                            <span><i class="fas fa-phone"></i></span>
                        </div>
                    </div>
                `;
                        card_header_msg_head.insertAdjacentHTML('beforeend', UI_bd_highlight);
                    }
                });
            }).catch(error => {
                console.error(error);
            });
        }
    </script>
    <script type="module">
        Echo.join('chat')
            .here(users => {
                let activeUserIds = [];
                users.forEach(user => {


                    //     // Find the user item by id
                    var userItem = document.querySelector(`#user${user.id}`);


                    if (userItem) {
                        // Find the img_cont inside the user item
                        var imgCont = userItem.querySelector('.img_cont');

                        // Check if the online_icon already exists to prevent duplicates

                        var status = document.createElement('span');
                        status.classList.add('online_icon');

                        // Append the span inside the correct img_cont
                        imgCont.appendChild(status);

                    }
                    var idUserReciever = document.querySelector('#idUserReciever')
                    var card_header_msg_head = document.querySelector('.msg_head')
                    var UI_bd_highlight = ''

                    if (user.id == idUserReciever.value) {
                        UI_bd_highlight = `
                <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    <img src="${user.image}"
                                        class="rounded-circle user_img">
                                    <span class="online_icon"></span>
                                </div>
                                <div class="user_info">
                                    <span>${user.name}</span>
                                    <p>Hoạt động 45 phút trước</p>
                                </div>
                                <div class="video_cam">
                                    <span><i class="fas fa-video"></i></span>
                                    <span><i class="fas fa-phone"></i></span>
                                </div>
                            </div>
                `
                    }
                    card_header_msg_head.insertAdjacentHTML('afterbegin', UI_bd_highlight)
                    if (user.id !== '{{ Auth::user()->id }}') {
                        activeUserIds.push(user.id);
                    }


                });

                chatUserInactive(activeUserIds);

            })
            .joining(user => {
                var el = document.querySelector(`#user${user.id}`)
                if (el) {
                    var img_cont = el.querySelector('.img_cont')
                    if (img_cont) {
                        var el_status = document.createElement('span')
                        el_status.classList.add('online_icon')
                        img_cont.appendChild(el_status)
                    }
                }
            })
            .leaving(user => {
                var el = document.querySelector(`#user${user.id}`)
                if (el) {
                    var img_cont = el.querySelector('.img_cont')


                    var el_status = img_cont.querySelector('.online_icon')
                    console.log(el_status);
                    if (el_status) {
                        img_cont.removeChild(el_status)
                    }
                }
            })


        var content_message = document.querySelector('#content_message')

        var idUserReciever = document.querySelector('#idUserReciever')
        
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



        fa_location_arrow.addEventListener('click', function() {

            let messageContent = content_message.value.trim();
            content_message.value = '';
            if (send_btn.contains(fa_location_arrow)) {
                send_btn.removeChild(fa_location_arrow);
            }
            axios.post('/message-private', {
                    message: messageContent,
                    idUserReciever: idUserReciever.value,
                })
                .then(function(response) {
                    
                })
        })
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
                const currentTimestamp = Math.floor(Date.now() / 1000); // Current time in seconds
                var msg_card_body = document.querySelector('.msg_card_body');
                var card_header_msg_head = document.querySelector('.msg_head')
                var UI_bd_highlight = `
                <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    <img src="${event.idUserReciever.image}"
                                        class="rounded-circle user_img">
                                    <span class="online_icon"></span>
                                </div>
                                <div class="user_info">
                                    <span>${event.idUserReciever.name}</span>
                                    <p>Hoạt động 45 phút trước</p>
                                </div>
                                <div class="video_cam">
                                    <span><i class="fas fa-video"></i></span>
                                    <span><i class="fas fa-phone"></i></span>
                                </div>
                            </div>
                `



                var ui = ''
                if (event.idUserSend.id == '{{ Auth::user()->id }}') {
                    ui = `
                   <div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                   ${event.message}
                                    <span class="msg_time" data-timestamp="${currentTimestamp}"></span>
                                </div>
                                <div class="img_cont_msg">
                                    <img src="${event.idUserSend.image}"
                                        class="rounded-circle user_img_msg">
                                </div>
                            </div>
              `
                } else {
                    ui =
                        `
                     <div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="${event.idUserReciever.image}" class="rounded-circle user_img_msg">
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
                                    <img src="${event.idUserReciever.image}"
                                        class="rounded-circle user_img_msg">
                                </div>
                            </div>
              `
                } else {
                    ui =
                        `
                     <div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="${event.idUserReciever.image}" class="rounded-circle user_img_msg">
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
            })
    </script>
    <script>
        var search_text = document.querySelector('.search-text')
        var contacts = document.querySelector('.contacts');

        search_text.addEventListener('input', function() {
            var query = search_text.value.trim();


            axios.post('search', {
                    search_text: query
                })
                .then(function(response) {

                    var ui = '';
                    if (response.data && response.data.data) {
                        response.data.data.forEach(function(user) {
                            ui += `
                <li>
                    <a href="{{ url('chat-private/${user.id}') }}" id="user${user.id}">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="${user.image}" class="rounded-circle user_img">
                            </div>
                            <div class="user_info">
                                <span>${user.name}</span>
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
	</body>
</html>
