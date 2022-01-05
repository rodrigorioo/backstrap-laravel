@extends('backstrap_laravel::admin.layout')

@section('title', __('backstrap_laravel::roles.name_plural').' | '.__('backstrap_laravel::roles.edit.title'))

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => __('backstrap_laravel::roles.edit.list_of'),
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')
            ],
            [
                'text' => __('backstrap_laravel::roles.edit.breadcrumb_title'),
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                <div class="card-header">
                    <strong>{{ __('backstrap_laravel::roles.name_singular') }}</strong>
                </div>

                {{ Form::open(['url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@update', $element), 'method' => 'PUT', 'files' => true]) }}

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('name', __('backstrap_laravel::roles.edit.input_name')) }}
                                    {{ Form::text('name', $element->name, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                    @if ($errors->has('name'))
                                        <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ Form::submit(__('backstrap_laravel::roles.edit.submit_button'), ['class' => 'btn btn-success btn-sm']) }}
                    </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>

@stop

@push('js')

@endpush

