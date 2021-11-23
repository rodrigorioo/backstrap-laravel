@extends('backstrap_laravel::admin.layout')

@section('title', 'Roles | Crear')

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => 'Lista de roles',
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')
            ],
            [
                'text' => 'Crear',
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                {{ Form::open(['url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@store'), 'files' => true]) }}
                    <div class="card-header">
                        <strong>Roles</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('name', 'Nombre') }}
                                    {{ Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                    @if ($errors->has('name'))
                                        <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        {{ Form::submit('Crear', ['class' => 'btn btn-success btn-sm']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop

@push('js')

@endpush
