@extends('backstrap_laravel::admin.layout')

@section('title', __('backstrap_laravel::roles.name_plural').' | '.__('backstrap_laravel::roles.create.title'))

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => __('backstrap_laravel::roles.create.list_of'),
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')
            ],
            [
                'text' => __('backstrap_laravel::roles.create.breadcrumb_title'),
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
                        <strong>{{ __('backstrap_laravel::roles.name_plural') }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {{ Form::label('name', __('backstrap_laravel::roles.create.input_name')) }}
                                    {{ Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                                    @if ($errors->has('name'))
                                        <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        {{ Form::submit(__('backstrap_laravel::roles.create.submit_button'), ['class' => 'btn btn-success btn-sm']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop

@push('js')

@endpush
