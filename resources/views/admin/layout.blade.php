<!DOCTYPE html>
<!--
* Backstrap - Free Bootstrap Admin Template
* @version v0.2.0
* @link https://backstrap.net
* Copyright (c) 2018 Cristian Tabacitu
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
<head>
    {!! $templateConfiguration['meta_tags'] !!}

    <title>{{ $templateConfiguration['title'] }} - @yield('title')</title>

    {!! $templateConfiguration['css'] !!}

    @stack('css')

</head>
<body class="app aside-menu-fixed sidebar-lg-show">
<header class="app-header bg-light border-0 navbar" style="{!! $templateConfiguration['background_color_header'] !!}">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto ml-3" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="{{ url($templateConfiguration['prefix']) }}">
        @if($templateConfiguration['logo'] != '')
            <b>{{ $templateConfiguration['title'] }}</b>
        @elseif($templateConfiguration['logo_img'] != '')
            <img src="{{ $templateConfiguration['logo_img'] }}" class="img-fluid" style="max-height: 75px">
        @endif
    </a>

    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show"><span class="navbar-toggler-icon"></span></button>

    <!-- TODO: Navbar options -->
{{--    <ul class="nav navbar-nav d-md-down-none">--}}
{{--        <li class="nav-item px-3"><a class="nav-link" href="#">Dashboard</a></li>--}}
{{--        <li class="nav-item px-3"><a class="nav-link" href="#">Users</a></li>--}}
{{--        <li class="nav-item px-3"><a class="nav-link" href="#">Settings</a></li>--}}
{{--    </ul>--}}

    <ul class="nav navbar-nav ml-auto">

        <!-- TODO: Notifications -->
{{--        <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span></a></li>--}}

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                {{ $templateConfiguration['logged_user']->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header"><strong>{{ __('backstrap_laravel::layout.settings') }}</strong></div>
                <a class="dropdown-item" href="{{ action('Rodrigorioo\BackStrapLaravel\Http\Controllers\ProfileController@index') }}">
                    <i class="fa fa-user"></i> {{ __('backstrap_laravel::layout.profile') }}
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url($templateConfiguration['login_configuration']['full_logout_url']) }}">
                    <i class="fa fa-lock"></i> {{ __('backstrap_laravel::layout.logout') }}
                </a>
            </div>
        </li>
    </ul>

    <!-- TODO: Aside menu -->
{{--    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show"><span class="navbar-toggler-icon"></span></button>--}}
{{--    <button class="navbar-toggler aside-menu-toggler d-lg-none mr-3" type="button" data-toggle="aside-menu-show"><span class="navbar-toggler-icon"></span></button>--}}

</header>
<div class="app-body">
    <div class="sidebar sidebar-pills bg-transparent" style="{!! $templateConfiguration['background_color_navbar'] !!}">
        <nav class="sidebar-nav">
            <ul class="nav">
                {!! $templateConfiguration['menu'] !!}
            </ul>
        </nav>
    </div>
    <main class="main" style="{!! $templateConfiguration['background_color_body'] !!}">

        @yield('breadcrumbs')

        <div class="container-fluid">
            <div class="animated fadeIn">

                @yield('content')

            </div>
        </div>
    </main>

    <!-- TODO: Aside menu -->

{{--    <aside class="aside-menu">--}}
{{--        <ul class="nav nav-tabs" role="tablist">--}}
{{--            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#timeline" role="tab"><i class="icon-list"></i></a></li>--}}
{{--            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages" role="tab"><i class="icon-speech"></i></a></li>--}}
{{--            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#settings" role="tab"><i class="icon-settings"></i></a></li>--}}
{{--        </ul>--}}
{{--        <!-- Tab panes-->--}}
{{--        <div class="tab-content">--}}
{{--            <div class="tab-pane active" id="timeline" role="tabpanel">--}}
{{--                <div class="list-group list-group-accent">--}}
{{--                    <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Today</div>--}}
{{--                    <div class="list-group-item list-group-item-accent-warning list-group-item-divider">--}}
{{--                        <div class="avatar float-right"><img class="img-avatar" src="img/avatars/7.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                        <div>Meeting with<strong>Lucas</strong></div><small class="text-muted mr-3"><i class="icon-calendar"></i>?? 1 - 3pm</small><small class="text-muted"><i class="icon-location-pin"></i>?? Palo Alto, CA</small>--}}
{{--                    </div>--}}
{{--                    <div class="list-group-item list-group-item-accent-info">--}}
{{--                        <div class="avatar float-right"><img class="img-avatar" src="img/avatars/4.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                        <div>Skype with<strong>Megan</strong></div><small class="text-muted mr-3"><i class="icon-calendar"></i>?? 4 - 5pm</small><small class="text-muted"><i class="icon-social-skype"></i>?? On-line</small>--}}
{{--                    </div>--}}
{{--                    <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Tomorrow</div>--}}
{{--                    <div class="list-group-item list-group-item-accent-danger list-group-item-divider">--}}
{{--                        <div>New UI Project -<strong>deadline</strong></div><small class="text-muted mr-3"><i class="icon-calendar"></i>?? 10 - 11pm</small><small class="text-muted"><i class="icon-home"></i>?? creativeLabs HQ</small>--}}
{{--                        <div class="avatars-stack mt-2">--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/2.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/3.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/4.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/5.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/6.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="list-group-item list-group-item-accent-success list-group-item-divider">--}}
{{--                        <div><strong>#10 Startups.Garden</strong> Meetup</div><small class="text-muted mr-3"><i class="icon-calendar"></i>?? 1 - 3pm</small><small class="text-muted"><i class="icon-location-pin"></i>?? Palo Alto, CA</small>--}}
{{--                    </div>--}}
{{--                    <div class="list-group-item list-group-item-accent-primary list-group-item-divider">--}}
{{--                        <div><strong>Team meeting</strong></div><small class="text-muted mr-3"><i class="icon-calendar"></i>?? 4 - 6pm</small><small class="text-muted"><i class="icon-home"></i>?? creativeLabs HQ</small>--}}
{{--                        <div class="avatars-stack mt-2">--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/2.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/3.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/4.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/5.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/6.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/7.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                            <div class="avatar avatar-xs"><img class="img-avatar" src="img/avatars/8.jpg" alt="admin@bootstrapmaster.com"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="tab-pane p-3" id="messages" role="tabpanel">--}}
{{--                <div class="message">--}}
{{--                    <div class="py-3 pb-5 mr-3 float-left">--}}
{{--                        <div class="avatar"><img class="img-avatar" src="img/avatars/7.jpg" alt="admin@bootstrapmaster.com"><span class="avatar-status badge-success"></span></div>--}}
{{--                    </div>--}}
{{--                    <div><small class="text-muted">Lukasz Holeczek</small><small class="text-muted float-right mt-1">1:52 PM</small></div>--}}
{{--                    <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div><small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="message">--}}
{{--                    <div class="py-3 pb-5 mr-3 float-left">--}}
{{--                        <div class="avatar"><img class="img-avatar" src="img/avatars/7.jpg" alt="admin@bootstrapmaster.com"><span class="avatar-status badge-success"></span></div>--}}
{{--                    </div>--}}
{{--                    <div><small class="text-muted">Lukasz Holeczek</small><small class="text-muted float-right mt-1">1:52 PM</small></div>--}}
{{--                    <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div><small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="message">--}}
{{--                    <div class="py-3 pb-5 mr-3 float-left">--}}
{{--                        <div class="avatar"><img class="img-avatar" src="img/avatars/7.jpg" alt="admin@bootstrapmaster.com"><span class="avatar-status badge-success"></span></div>--}}
{{--                    </div>--}}
{{--                    <div><small class="text-muted">Lukasz Holeczek</small><small class="text-muted float-right mt-1">1:52 PM</small></div>--}}
{{--                    <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div><small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="message">--}}
{{--                    <div class="py-3 pb-5 mr-3 float-left">--}}
{{--                        <div class="avatar"><img class="img-avatar" src="img/avatars/7.jpg" alt="admin@bootstrapmaster.com"><span class="avatar-status badge-success"></span></div>--}}
{{--                    </div>--}}
{{--                    <div><small class="text-muted">Lukasz Holeczek</small><small class="text-muted float-right mt-1">1:52 PM</small></div>--}}
{{--                    <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div><small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="message">--}}
{{--                    <div class="py-3 pb-5 mr-3 float-left">--}}
{{--                        <div class="avatar"><img class="img-avatar" src="img/avatars/7.jpg" alt="admin@bootstrapmaster.com"><span class="avatar-status badge-success"></span></div>--}}
{{--                    </div>--}}
{{--                    <div><small class="text-muted">Lukasz Holeczek</small><small class="text-muted float-right mt-1">1:52 PM</small></div>--}}
{{--                    <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div><small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="tab-pane p-3" id="settings" role="tabpanel">--}}
{{--                <h6>Settings</h6>--}}
{{--                <div class="aside-options">--}}
{{--                    <div class="clearfix mt-4"><small><b>Option 1</b></small>--}}
{{--                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">--}}
{{--                            <input class="switch-input" type="checkbox" checked=""><span class="switch-slider" data-checked="On" data-unchecked="Off"></span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                    <div><small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></div>--}}
{{--                </div>--}}
{{--                <div class="aside-options">--}}
{{--                    <div class="clearfix mt-3"><small><b>Option 2</b></small>--}}
{{--                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">--}}
{{--                            <input class="switch-input" type="checkbox"><span class="switch-slider" data-checked="On" data-unchecked="Off"></span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                    <div><small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></div>--}}
{{--                </div>--}}
{{--                <div class="aside-options">--}}
{{--                    <div class="clearfix mt-3"><small><b>Option 3</b></small>--}}
{{--                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">--}}
{{--                            <input class="switch-input" type="checkbox"><span class="switch-slider" data-checked="On" data-unchecked="Off"></span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="aside-options">--}}
{{--                    <div class="clearfix mt-3"><small><b>Option 4</b></small>--}}
{{--                        <label class="switch switch-label switch-pill switch-success switch-sm float-right">--}}
{{--                            <input class="switch-input" type="checkbox" checked=""><span class="switch-slider" data-checked="On" data-unchecked="Off"></span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <h6>System Utilization</h6>--}}
{{--                <div class="text-uppercase mb-1 mt-4"><small><b>CPU Usage</b></small></div>--}}
{{--                <div class="progress progress-xs">--}}
{{--                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                </div><small class="text-muted">348 Processes. 1/4 Cores.</small>--}}
{{--                <div class="text-uppercase mb-1 mt-2"><small><b>Memory Usage</b></small></div>--}}
{{--                <div class="progress progress-xs">--}}
{{--                    <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                </div><small class="text-muted">11444GB/16384MB</small>--}}
{{--                <div class="text-uppercase mb-1 mt-2"><small><b>SSD 1 Usage</b></small></div>--}}
{{--                <div class="progress progress-xs">--}}
{{--                    <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                </div><small class="text-muted">243GB/256GB</small>--}}
{{--                <div class="text-uppercase mb-1 mt-2"><small><b>SSD 2 Usage</b></small></div>--}}
{{--                <div class="progress progress-xs">--}}
{{--                    <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                </div><small class="text-muted">25GB/256GB</small>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </aside>--}}

</div>
<footer class="app-footer" style="{!! $templateConfiguration['background_color_footer'] !!}">
    <div>
        <span>{!! $templateConfiguration['footer']['credits'] !!}</span>
    </div>
</footer>

{!! $templateConfiguration['js'] !!}

@stack('js')

</body>
</html>