@extends('backstrap_laravel::admin.layout')

@section('title', $modelNamePlural.' | '.__('backstrap_laravel::crud.index.title'))

@section('breadcrumbs')

    {!! BackStrapLaravel::breadcrumbs([
            BackStrapLaravel::getHomeBreadcrumb(),
            $parentBreadcrumbs,
            [
                'text' => __('backstrap_laravel::crud.index.list_of').$modelNamePlural,
            ],
        ]) !!}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <x-backstrap_laravel::alert></x-backstrap_laravel::alert>

            <div class="card">
                <div class="card-header">
                    <strong>{{ $modelNamePlural }}</strong>
                    <div class="card-header-actions">
                        <a class="btn btn-block btn-success btn-sm" href="{{ $urlCreate }}">
                            <i class="icon-plus"></i> {{ __('backstrap_laravel::crud.index.new') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered administrators">
                        <thead>
                        <tr>
                            @foreach($columnsTable as $columnTable)
                                <th>{{ $columnTable }}</th>
                            @endforeach
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

    let columns = [];

    @foreach($columns as $columnName => $column)
        columns.push({
            data: "{{ $columnName }}",
            name: "{{ $columnName }}",
        });
    @endforeach

    columns.push({
        data: 'actions',
        name: 'actions',
    });

    var table = $('.administrators').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ $urlIndex }}",
        columns: columns,
        // columns: [
        //     {
        //         data: 'name',
        //         name: 'name',
        //     },
        //     {
        //         data: 'email',
        //         name: 'email',
        //     },
        //     {
        //         data: 'is_active',
        //         name: 'is_active',
        //     },
        //     {
        //         data: 'action',
        //         name: 'action',
        //     },
        // ]
    });

});
</script>
@endpush
