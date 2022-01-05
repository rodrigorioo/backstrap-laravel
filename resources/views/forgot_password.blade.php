<!DOCTYPE html>

<html lang="en">
<head>

    {!! $templateConfiguration['meta_tags'] !!}

    <title>{{ $templateConfiguration['title'] }} - {{ __('backstrap_laravel::forgot_password.title') }}</title>

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

                        <h1>{{ __('backstrap_laravel::forgot_password.forgot_password') }}</h1>
                        <p class="text-muted">{{ __('backstrap_laravel::forgot_password.request_change') }}</p>

                        @if(session('success'))

                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>

                        @else

                            {{ Form::open(['url' => url($templateConfiguration['login_configuration']['full_forgot_password_url']), 'method' => 'POST', 'files' => true]) }}

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-envelope"></i>
                                            </span>
                                    </div>
                                    {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required']) }}
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{ Form::submit(__('backstrap_laravel::forgot_password.request_change_submit'), ['class' => 'btn btn-primary px-4']) }}
                                    </div>
                                </div>

                            {{ Form::close() }}

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{!! $templateConfiguration['js'] !!}

</body>
</html>