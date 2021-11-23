@extends('backstrap_laravel::admin.layout')

@section('title', 'Roles | Editar')

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => 'Lista de roles',
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')
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
                    <strong>Rol</strong>
                </div>

                {{ Form::open(['url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@update', $element), 'method' => 'PUT', 'files' => true]) }}

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
                    </div>

                    <div class="card-footer">
                        {{ Form::submit('Guardar', ['class' => 'btn btn-success btn-sm']) }}
                    </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>

@stop

@push('js')

@endpush

