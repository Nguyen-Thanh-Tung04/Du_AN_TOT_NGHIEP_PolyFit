<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('theme/client/assets/css/chat.css')}}" />
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

<div class="container app">
	<div class="row app-one">
		<div class="col-sm-4 side">
			<div class="side-one">
				<div class="row heading">
					<div class="col-sm-3 col-xs-3 heading-avatar">
						<div class="heading-avatar-icon">
							<img src="https://bootdey.com/img/Content/avatar/avatar1.png">
						</div>
					</div>
					<div class="col-sm-1 col-xs-1  heading-dot  pull-right">
						<i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
					</div>
					<div class="col-sm-2 col-xs-2 heading-compose  pull-right">
						<i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>
					</div>
				</div>

				<div class="row searchBox">
					<div class="col-sm-12 searchBox-inner">
						<div class="form-group has-feedback">
							<input id="searchText" type="text" class="form-control" name="searchText" placeholder="Search">
							<span class="glyphicon glyphicon-search form-control-feedback"></span>
						</div>
					</div>
				</div>

				<div class="row sideBar">
					<div class="row sideBar-body">
							<a href="#" id="user{{ $user->id }}">
								<div class="col-sm-3 col-xs-3 sideBar-avatar img_cont">
									<div class="avatar-icon">
										<img src="{{ $user->image}}">
									</div>
									<!-- <div class="online_icon"></div> -->
								</div>
								<div class="col-sm-9 col-xs-9 sideBar-main">
									<div class="row">
										<div class="col-sm-8 col-xs-8 sideBar-name">
											<span class="name-meta">{{ $user->name}}
											</span>
										</div>
										<div class="col-sm-4 col-xs-4 pull-right sideBar-time">
											<span class="time-meta pull-right">18:18
											</span>
										</div>
										
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
		</div>

		<div class="col-sm-8 conversation">
			<div class="row heading">
				<div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
					<div class="heading-avatar-icon">
						<img src="https://bootdey.com/img/Content/avatar/avatar6.png">
					</div>
				</div>
				<div class="col-sm-8 col-xs-7 heading-name">
					<a class="heading-name-meta">John Doe
					</a>
					<span class="heading-online">Online</span>
				</div>
				<div class="col-sm-1 col-xs-1  heading-dot pull-right">
					<i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
				</div>
			</div>

			<div class="row message" id="conversation">
				<div class="row message-previous">
					<div class="col-sm-12 previous">
						<a onclick="previous(this)" id="ankitjain28" name="20">
                            Hiển thị tin nhắn trước!
						</a>
					</div>
				</div>

				<div class="row message-body">
					<div class="col-sm-12 message-main-receiver">
						<div class="receiver">
							<div class="message-text">
								Hi, what are you doing?!
							</div>
							<span class="message-time pull-right">
								Sun
							</span>
						</div>
					</div>
				</div>

				<div class="row message-body">
					<div class="col-sm-12 message-main-sender">
						<div class="sender">
							<div class="message-text">
								I am doing nothing man!
							</div>
							<span class="message-time pull-right">
								Sun
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="row reply">
				<div class="col-sm-1 col-xs-1 reply-emojis">
					<i class="fa fa-smile-o fa-2x"></i>
				</div>
				<div class="col-sm-9 col-xs-9 reply-main">
					<textarea class="form-control" rows="1" id="comment"></textarea>
				</div>
				<div class="col-sm-1 col-xs-1 reply-recording">
					<i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
				</div>
				<div class="col-sm-1 col-xs-1 reply-send">
					<i class="fa fa-send fa-2x" aria-hidden="true"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="module">
	Echo.join('chat')
	.here(users => {
		users.forEach(user => {
                    var userusers = document.querySelector(`#user${user.id}`);
                    if (userusers) {
                        var imgCont = userusers.querySelector('.img_cont');
                        var status = document.createElement('span');
                        status.classList.add('online_icon');
                        imgCont.appendChild(status);

                    }
                });

	}).joining(user => {
                var el = document.querySelector(`#user${user.id}`)
                if (el) {
                    var img_cont = el.querySelector('.img_cont')
                    if (img_cont) {
                        var el_status = document.createElement('span')
                        el_status.classList.add('online_icon')
                        img_cont.appendChild(el_status)
                    }
                }
	}).leaving(user => {
		var el = document.querySelector(`#user${user.id}`)
		if (el) {
			var img_cont = el.querySelector('.img_cont')


			var el_status = img_cont.querySelector('.online_icon')
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
</body>
</html>