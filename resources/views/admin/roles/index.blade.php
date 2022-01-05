@extends('backstrap_laravel::admin.layout')

@section('title', __('backstrap_laravel::roles.name_plural').' | '.__('backstrap_laravel::roles.index.title'))

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => __('backstrap_laravel::roles.index.list_of'),
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                <div class="card-header">
                    <strong>Roles</strong>
                    <div class="card-header-actions">
                        <a class="btn btn-block btn-success btn-sm" href="{{ action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@create') }}">
                            <i class="icon-plus"></i> {{ __('backstrap_laravel::roles.index.new') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered roles">
                        <thead>
                        <tr>
                            <th>{{ __('backstrap_laravel::roles.index.name') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
<script>
$(function () {

    var table = $('.roles').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index') }}",
        columns: [
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'action',
                name: 'action',
            },
        ]
    });

});
</script>
@endpush
