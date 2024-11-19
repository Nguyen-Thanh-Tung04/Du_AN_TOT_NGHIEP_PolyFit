@php
$segment = request()->segment(1);
@endphp

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element text-center">
                    <!-- Container for the image -->
                    @if(Auth::check())
                        @if (Auth::user()->image)
                            <!-- Nếu user có ảnh đại diện -->
                            <img alt="image" class="rounded-circle mx-auto d-block" 
                                src="{{ Auth::user()->image }}" 
                                style="width: 46px; height: 46px; object-fit: cover; overflow: hidden; border-radius: 50%;" />
                        @else
                            <!-- Nếu không có ảnh đại diện -->
                            <img alt="image" class="rounded-circle mx-auto d-block" 
                                src="{{ asset('userfiles/image/avata_null.jpg')}}" 
                                style="width: 80px; height: 80px; object-fit: cover; overflow: hidden; border-radius: 50%;" />
                        @endif
                    @else
                        <!-- Nếu chưa đăng nhập -->
                        <i class="fi-rr-user" style="font-size: 80px;"></i>
                    @endif
                
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                              </span> <span class="text-muted text-xs block">{{ Auth::user()->user_catalogues->name }} <b class="caret"></b></span> </span> </a>
                </div>
                
            </li>
            <li class="active">
                <a href="{{ route('dashboard.index') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Thống Kê</span> <span class="fa arrow"></span></a>
            </li>
            <li >
                <a href="{{ route('list-chat') }}"><i class="fa fa-comment"></i> <span class="nav-label">Chat</span> <span class="fa arrow"></span></a>
            </li>
            @foreach (config('apps.module.module') as $val)
            <li class="{{ (in_array($segment, $val['name'])) ? 'active' : '' }}">
                <a @if(isset($val['subModule'])) href="#" @else href="{{ $val['route'] }}" @endif>
                    <i class="{{ $val['icon'] }}"></i>
                    <span class="nav-label">{{ $val['title'] }}</span>
                    @if (isset($val['subModule']) && count($val['subModule']) > 0)
                    <span class="fa arrow"></span>
                    @endif
                </a>
                @if (isset($val['subModule']) && count($val['subModule']) > 0)
                <ul class="nav nav-second-level">
                    @foreach ($val['subModule'] as $module)
                    <li><a href="{{ $module['route'] }}">{{ $module['title'] }}</a></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach

        </ul>

    </div>
</nav>