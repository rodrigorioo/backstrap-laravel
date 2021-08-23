@extends('backstrap_laravel::admin.layout')

@section('title', 'Administradores | Editar')

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => 'Lista de administradores',
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')
            ],
            [
                'text' => 'Editar',
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                <div class="card-header">
                    <strong>Administrador</strong>
                </div>

                {{ Form::open(['url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@update', $element), 'method' => 'PUT', 'files' => true]) }}

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('name', 'Nombre') }}
                                    {{ Form::text('name', $element->name, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

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
                                    {{ Form::email('email', $element->email, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'required' => 'required']) }}

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

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('role', 'Rol') }}
                                    {{ Form::select('role', $roles, $element->roles()->first()->id, ['class' => 'form-control '.($errors->has('role') ? 'is-invalid' : ''), 'required' => 'required', 'placeholder' => 'Seleccionar']) }}

                                    @if ($errors->has('role'))
                                        <span class="error invalid-feedback">{{ $errors->first('role') }}</span>
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
