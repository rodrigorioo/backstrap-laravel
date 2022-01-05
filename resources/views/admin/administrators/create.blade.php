@extends('backstrap_laravel::admin.layout')

@section('title', __('backstrap_laravel::administrators.name_plural').' | '.__('backstrap_laravel::administrators.create.title'))

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => __('backstrap_laravel::administrators.create.list_of'),
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')
            ],
            [
                'text' => __('backstrap_laravel::administrators.create.breadcrumb_title'),
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                {{ Form::open(['url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@store'), 'files' => true]) }}
                    <div class="card-header">
                        <strong>{{ __('backstrap_laravel::administrators.name_plural') }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('name', __('backstrap_laravel::administrators.create.input_name')) }}
                                    {{ Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                    @if ($errors->has('name'))
                                        <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('email', 'Email') }}
                                    {{ Form::email('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                    @if ($errors->has('email'))
                                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('password', 'Password') }}
                                    {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                    @if ($errors->has('password'))
                                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('password_confirmation', __('backstrap_laravel::administrators.create.confirm_password')) }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control '.($errors->has('password_confirmation') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                    @if ($errors->has('password_confirmation'))
                                        <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('role', __('backstrap_laravel::administrators.create.role')) }}
                                    {{ Form::select('role', $roles, null, ['class' => 'form-control '.($errors->has('role') ? 'is-invalid' : ''), 'required' => 'required', 'placeholder' => __('backstrap_laravel::administrators.create.role_select')]) }}

                                    @if ($errors->has('role'))
                                        <span class="error invalid-feedback">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ Form::submit(__('backstrap_laravel::administrators.create.submit_button'), ['class' => 'btn btn-success btn-sm']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop
