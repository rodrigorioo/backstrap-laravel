@extends('backstrap_laravel::admin.layout')

@section('title', $modelNamePlural.' | Crear')

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => 'Lista de '.$modelNamePlural,
                'url' => $urlIndex,
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
                {{ Form::open(['url' => $urlStore, 'files' => true]) }}
                    <div class="card-header">
                        <strong>{{ $modelNamePlural }}</strong>
                    </div>
                    <div class="card-body">

                        @foreach($fields as $fieldName => $fieldData)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label($fieldName, $fieldData['name']) }}
                                        {!! BackStrapLaravel::getFormInput($fieldName, $fieldData, $errors) !!}

                                        @if ($errors->has($fieldName))
                                            <span class="error invalid-feedback">{{ $errors->first($fieldName) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="card-footer">
                        {{ Form::submit('Crear', ['class' => 'btn btn-success btn-sm']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop
