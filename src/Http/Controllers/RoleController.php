<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Rodrigorioo\BackStrapLaravel\Http\Requests\CreateRoleRequest;
use Rodrigorioo\BackStrapLaravel\Http\Requests\EditRoleRequest;
use Rodrigorioo\BackStrapLaravel\Http\Requests\UpdatePermissionsRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
//    public function __construct () {
//        $guardName = config('backstrap_laravel.guard.name');
//
//        $this->middleware('permission:listar roles,'.$guardName, ['only' => ['index']]);
//        $this->middleware('permission:crear rol,'.$guardName, ['only' => ['create']]);
//        $this->middleware('permission:guardar rol,'.$guardName, ['only' => ['store']]);
//        $this->middleware('permission:ver rol,'.$guardName, ['only' => ['show']]);
//        $this->middleware('permission:ver rol,'.$guardName, ['only' => ['edit']]);
//        $this->middleware('permission:editar rol,'.$guardName, ['only' => ['update']]);
//        $this->middleware('permission:eliminar rol,'.$guardName, ['only' => ['destroy']]);
//
//        $this->middleware('permission:editar permisos de rol,'.$guardName, ['only' => ['permissions', 'updatePermissions']]);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $places = Role::latest()->get();

            return DataTables::of($places)
                ->editColumn('name', function(Role $role) {
                    return $role->name;
                })
                ->addColumn('action', function(Role $role) {

                    $editBtn = '<a href="'. action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@edit', $role) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@destroy',
                            $role).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este rol?\')">Borrar</button></form>';

                    $permissionsBtn = '';
                    $crudPermissions = config('backstrap_laravel.crud_permissions.enable');
                    if($crudPermissions) {
                        $permissionsBtn = '<div class="d-flex align-items-center mt-2">
                        <a href="'. action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@permissions', $role) .'" class="edit btn btn-warning btn-sm mr-2">Ver permisos</a>
                    </div>';
                    }

                    $action = $editBtn . ' ' . $deleteBtn. ' '.$permissionsBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backstrap_laravel::admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backstrap_laravel::admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = config('backstrap_laravel.guard.name');

        if ($role->save()) {

            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')->withAlert($alertSuccess);
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')->withAlert($alertError);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $this->edit($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('backstrap_laravel::admin.roles.edit')->with([
            'element' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(EditRoleRequest $request, Role $role)
    {
        $role->name = $request->input('name');

        if ($role->save()) {

            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')->withAlert($alertSuccess);
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')->withAlert($alertError);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->delete()) {

            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')->withAlert($alertSuccess);
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController@index')->withAlert($alertError);
    }

    public function permissions(Role $role) {

        $permissions = Permission::all();

        return view('backstrap_laravel::admin.roles.permissions')->with([
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function updatePermissions(UpdatePermissionsRequest $request, Role $role) {

        $role->syncPermissions($request->input('permissions'));

        $alertSuccess = config('backstrap_laravel.alert_success');
        return Redirect::action('App\Http\Controllers\Backend\RoleController@permissions', [$role])->withAlert($alertSuccess);
    }
}