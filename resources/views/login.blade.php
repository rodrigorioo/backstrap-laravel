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

    <title>{{ $templateConfiguration['title'] }} - Login</title>

    {!! $templateConfiguration['css'] !!}
</head>

<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">

                        <x-backstrap_laravel::errors></x-backstrap_laravel::errors>

                        <h1>Login</h1>
                        <p class="text-muted">{{ __('backstrap_laravel::login.sign_in') }}</p>

                        {{ Form::open(['url' => url($templateConfiguration['login_configuration']['full_login_url']), 'method' => 'POST', 'files' => true]) }}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-envelope"></i>
                                    </span>
                                </div>
                                {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required']) }}
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-lock"></i>
                                    </span>
                                </div>
                                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => 'required']) }}
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    {{ Form::submit('Login', ['class' => 'btn btn-primary px-4']) }}
                                </div>

                                @if($templateConfiguration['login_configuration']['forgot_password_url'])
                                    <div class="col-6 text-right">
                                        <a href="{{ url($templateConfiguration['login_configuration']['full_forgot_password_url']) }}">
                                            <button class="btn btn-link px-0" type="button">{{ __('backstrap_laravel::login.forgot_password') }}</button>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        {{ Form::close() }}

                    </div>
                </div>

                @if($templateConfiguration['login_configuration']['register_url'])
                    <!-- TODO: Register -->
                    <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2>Sign up</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <button class="btn btn-primary active mt-3" type="button">Register Now!</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{!! $templateConfiguration['js'] !!}

</body>
</html>