<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers;

use Rodrigorioo\BackStrapLaravel\Http\Controllers\Controller;
use Rodrigorioo\BackStrapLaravel\Http\Requests\ChangeStatusAdministratorRequest;
use Rodrigorioo\BackStrapLaravel\Http\Requests\CreateAdministratorRequest;
use Rodrigorioo\BackStrapLaravel\Http\Requests\EditAdministratorRequest;
use Rodrigorioo\BackStrapLaravel\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdministratorController extends Controller
{
    /** HELPER FUNCTIONS */

    public function getRolesSelect () {
        $return = [];
        $roles = Role::all();

        foreach($roles as $role) {
            $return[$role->id] = $role->name;
        }

        return $return;
    }

    /** END HELPER FUNCTIONS */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $administrators = Administrator::latest()->get();

            return DataTables::of($administrators)
                ->editColumn('name', function(Administrator $administrator) {
                    return $administrator->name;
                })
                ->editColumn('email', function(Administrator $administrator) {
                    return $administrator->email;
                })
                ->editColumn('is_active', function(Administrator $administrator) {
                    return $administrator->is_active ? 'SÍ' : 'NO';
                })
                ->addColumn('action', function(Administrator $administrator) {

                    $statusBtn = '<a href="'. action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@changeStatus', $administrator)
                        .'" class="active btn btn-info btn-sm">Cambiar estado</a>';
                    $editBtn = '<a href="'. action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@edit', $administrator) .'" class="edit btn btn-success btn-sm">Editar</a>';
                    $deleteBtn = '<form method="POST" action="'.action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@destroy',
                            $administrator).'">'.csrf_field().'<input type="hidden" name="_method" value="DELETE"><button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este usuario?\')">Borrar</button></form>';

                    $action = $statusBtn . ' ' . $editBtn . ' ' . $deleteBtn;

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backstrap_laravel::admin.administrators.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backstrap_laravel::admin.administrators.create')->with([
            'roles' => $this->getRolesSelect(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdministratorRequest $request)
    {
        $administrator = new Administrator;
        $administrator->name = $request->input('name');
        $administrator->email = $request->input('email');
        $administrator->password = Hash::make($request->input('password'));
        $administrator->syncRoles($request->input('role'));

        if ($administrator->save()) {
            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')->withAlert(array_merge($alertSuccess, [
                'title' => __('backstrap_laravel::alerts.success.title'),
                'text' => __('backstrap_laravel::alerts.success.text'),
                'close' => __('backstrap_laravel::alerts.success.close'),
            ]));
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')->withAlert(array_merge($alertError, [
            'title' => __('backstrap_laravel::alerts.error.title'),
            'text' => __('backstrap_laravel::alerts.error.text'),
            'close' => __('backstrap_laravel::alerts.error.close'),
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show(Administrator $administrator)
    {
        return $this->edit($administrator);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrator $administrator)
    {
        return view('backstrap_laravel::admin.administrators.edit')->with([
            'roles' => $this->getRolesSelect(),
            'element' => $administrator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Administrator $administrator)
    {
        $request = app(EditAdministratorRequest::class, ['administrator' => $administrator]);

        $administrator->name = $request->input('name');
        $administrator->email = $request->input('email');
        if($request->input('password') != '') {
            $administrator->password = Hash::make($request->input('password'));
        }
        $administrator->syncRoles($request->input('role'));

        if ($administrator->save()) {
            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')->withAlert(array_merge($alertSuccess, [
                'title' => __('backstrap_laravel::alerts.success.title'),
                'text' => __('backstrap_laravel::alerts.success.text'),
                'close' => __('backstrap_laravel::alerts.success.close'),
            ]));
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')->withAlert(array_merge($alertError, [
            'title' => __('backstrap_laravel::alerts.error.title'),
            'text' => __('backstrap_laravel::alerts.error.text'),
            'close' => __('backstrap_laravel::alerts.error.close'),
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $administrator)
    {
        $administrator->delete();

        $alertSuccess = config('backstrap_laravel.alert_success');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')->withAlert(array_merge($alertSuccess, [
            'title' => __('backstrap_laravel::alerts.success.title'),
            'text' => __('backstrap_laravel::alerts.success.text'),
            'close' => __('backstrap_laravel::alerts.success.close'),
        ]));
    }

    public function changeStatus(ChangeStatusAdministratorRequest $request, Administrator $administrator) {

        $administrator->is_active = $administrator->is_active ? 0 : 1;

        if ($administrator->save()) {
            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')->withAlert(array_merge($alertSuccess, [
                'title' => __('backstrap_laravel::alerts.success.title'),
                'text' => __('backstrap_laravel::alerts.success.text'),
                'close' => __('backstrap_laravel::alerts.success.close'),
            ]));
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController@index')->withAlert(array_merge($alertError, [
            'title' => __('backstrap_laravel::alerts.error.title'),
            'text' => __('backstrap_laravel::alerts.error.text'),
            'close' => __('backstrap_laravel::alerts.error.close'),
        ]));
    }
}
