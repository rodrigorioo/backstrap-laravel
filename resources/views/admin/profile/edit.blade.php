@extends('backstrap_laravel::admin.layout')

@section('title', 'Profile')

@section('breadcrumbs')
    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => 'Profile',
            ],
        ]) !!}
@stop

@section('content')

        <div class="row">
            <div class="col-md-12">

                <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

                <div class="card">
                    <div class="card-header">
                        <strong>Perfil</strong>
                    </div>

                    {{ Form::open(['url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\ProfileController@update'), 'method' => 'POST', 'files' => true]) }}

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Nombre') }}
                                        {{ Form::text('name', $user->name, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                        @if ($errors->has('name'))
                                            <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('password', 'Password') }}
                                        {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : '')]) }}

                                        @if ($errors->has('password'))
                                            <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', 'Confirm Password') }}
                                        {{ Form::password('password_confirmation', ['class' => 'form-control '.($errors->has('password_confirmation') ? 'is-invalid' : '')]) }}

                                        @if ($errors->has('password_confirmation'))
                                            <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            {{ Form::submit('Guardar', ['class' => 'btn btn-success btn-sm']) }}
                        </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>

@stop
