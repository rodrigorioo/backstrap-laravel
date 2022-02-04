@extends('backstrap_laravel::admin.layout')

@section('title', $modelNamePlural.' | '.__('backstrap_laravel::crud.edit.title'))

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => __('backstrap_laravel::crud.edit.list_of').$modelNamePlural,
                'url' => $urlIndex,
            ],
            [
                'text' => __('backstrap_laravel::crud.edit.breadcrumb_title'),
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                {{ Form::open(['url' => $urlUpdate, 'method' => 'PUT', 'files' => true]) }}
                <div class="card-header">
                    <strong>{{ $modelNamePlural }}</strong>
                </div>
                <div class="card-body">

                    @foreach($cards as $cardId => $card)
                        <div class="card {{ $card->getCardClass() }}">
                            <div class="card-header {{ $card->getHeaderClass() }}">
                                <strong>{{ $card->getName() }}</strong>
                            </div>
                            <div class="card-body {{ $card->getBodyClass() }}">

                                @foreach($card->getFields() as $field)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {!! $field->render($errors, $model) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    @endforeach

{{--                    @foreach($cards as $cardId => $cardData)--}}
{{--                        <div class="card {{ $cardData['card_class'] }}">--}}
{{--                            <div class="card-header {{ $cardData['header_class'] }}">--}}
{{--                                <strong>{{ $cardData['name'] }}</strong>--}}
{{--                            </div>--}}
{{--                            <div class="card-body {{ $cardData['body_class'] }}">--}}

{{--                                @foreach($cardData['fields'] as $fieldName => $fieldData)--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="form-group">--}}
{{--                                                {!! BackStrapLaravel::getFormInput($fieldName, $fieldData, $errors, $model) !!}--}}

{{--                                                {!! BackStrapLaravel::getInputErrorMessage($errors, $fieldName, $fieldData) !!}--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}

{{--                            </div>--}}
{{--                            <div class="card-footer">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}

{{--                    @foreach($fieldsWithoutInput as $fieldName => $fieldData)--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-sm-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    {!! BackStrapLaravel::getFormInput($fieldName, $fieldData, $errors, $model) !!}--}}

{{--                                    {!! BackStrapLaravel::getInputErrorMessage($errors, $fieldName, $fieldData) !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}

                        @foreach($fields as $field)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! $field->render($errors, $model) !!}
                                        {{--                                        {!! BackStrapLaravel::getFormInput($fieldName, $fieldData, $errors) !!}--}}

                                        {{--                                        {!! BackStrapLaravel::getInputErrorMessage($errors, $fieldName, $fieldData) !!}--}}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                </div>
                <div class="card-footer">
                    {{ Form::submit(__('backstrap_laravel::crud.edit.submit_button'), ['class' => 'btn btn-success btn-sm']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop

@push('js')

    <script src="{{ asset("vendor/backstrap_laravel/ckeditor/ckeditor.js") }}"></script>

    <script>
        $('textarea.ckeditor').each(function() {

            CKEDITOR.replace($(this).attr('name'), {
                customConfig: '/vendor/backstrap_laravel/ckeditor/config.js',
            });
        });
    </script>

@endpush
