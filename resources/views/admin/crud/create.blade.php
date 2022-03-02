@extends('backstrap_laravel::admin.layout')

@section('title', $modelNamePlural.' | '.__('backstrap_laravel::crud.create.title'))

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            $parentBreadcrumbs,
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

                        @if(array_key_exists('Spatie\Translatable\HasTranslations', class_uses($modelClass)))
                            {{ Form::hidden('_set_language', $languageSelected['language']) }}
                            <x-backstrap_laravel::select_language :languageSelected="$languageSelected"></x-backstrap_laravel::select_language>
                        @endif
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
                                                    {!! $field->render($errors) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        @endforeach

                        @foreach($fields as $field)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! $field->render($errors) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="card-footer">
                        {{ Form::submit(__('backstrap_laravel::crud.create.submit_button'), ['class' => 'btn btn-success btn-sm']) }}
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