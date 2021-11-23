@extends('backstrap_laravel::admin.layout')

@section('title', 'Permisos | Editar')

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            [
                'text' => 'Lista de roles',
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')
            ],
            [
                'text' => $role->name,
                'url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@edit', $role)
            ],
            [
                'text' => 'Permisos',
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                <div class="card-header">
                    <strong>Permisos</strong>
                </div>

                {{ Form::open(['url' => action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@permissions', $role), 'files' => true]) }}

                {{ Form::hidden('id', $role->id) }}

                <div class="d-none" id="selected-permissions">

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-checkable no-datatable">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td></td>
                                            <td>{{ $permission->id }}</td>
                                            <td>{{ $permission->name }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
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
    <script src="{{ asset('vendor/backstrap_laravel/js/roles_permissions.js') }}"></script>
@endpush

