@extends('backstrap_laravel::admin.layout')

@section('title', 'Administradores | Lista')

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => 'Lista de administradores',
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                <div class="card-header">
                    <strong>Administradores</strong>
                    <div class="card-header-actions">
                        <a class="btn btn-block btn-success btn-sm" href="{{ action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@create') }}">
                            <i class="icon-plus"></i> Nuevo</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered administrators">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Está activo?</th>
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

    var table = $('.administrators').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index') }}",
        columns: [
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'email',
                name: 'email',
            },
            {
                data: 'is_active',
                name: 'is_active',
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
