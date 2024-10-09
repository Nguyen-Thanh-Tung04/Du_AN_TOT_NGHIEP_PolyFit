@php
    $segment = request()->segment(1);
@endphp
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="admin/img/profile_small.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                             {{-- </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul> --}}
                </div>
                <div class="logo-element">
                    IN+
                </div>
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
