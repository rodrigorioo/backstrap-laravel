<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

class CRUDController extends Controller
{
    protected $model = null;
    protected $modelName = '';
    protected $modelNamePlural = '';

    protected $columns = [
        'fields' => [],
        'actions' => [
            [
                'type' => 'button',
                'url' => '',
                'classes' => 'btn btn-primary',
                'text' => 'Editar',
                'onclick' => '',
            ],
            [
                'type' => 'button',
                'url' => '',
                'classes' => 'btn btn-danger',
                'text' => 'Borrar',
                'onclick' => '',
            ],
        ],
    ];
    protected $fields = [];

    public function __construct () {

        // MODEL NAMES
        if($this->modelName == '') {
            $explodeModel = explode("\\", $this->model);

            $this->modelName = $explodeModel[count($explodeModel) - 1];

            if($this->modelNamePlural == '') {
                $this->modelNamePlural = $this->modelName.'s';
            }
        }
    }

    public function getUrl ($action, $id = null) {

        $url = '';
        $controller = explode('@', Route::currentRouteAction())[0];

        switch($action) {

            case 'create':
            case 'index':

                $url = action($controller.'@'.$action);
                break;

            case 'show':
            case 'edit':
            case 'update':
            case 'destroy':

                $url = action($controller.'@'.$action, $id);
                break;
        }

        return $url;
    }

    public function viewData () {
        return [
            'modelNamePlural' => $this->modelNamePlural,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $elements = $this->model::latest()->get();

            $datatables = DataTables::of($elements);

            foreach($this->columns as $column) {

                $datatables->editColumn($column['name'], function($element) use($column) {

                    $returnValue = null;

                     switch($column['type']) {

                         case 'text':

                             $returnValue = $column['name'];
                             break;
                     }

                     return $returnValue;
                });
            }

            $actions = $this->columns['actions'];
            $datatables->addColumn('actions', function($elemen) use($actions) {

                $buttons = '';

                foreach($actions as $action) {

                }

                $editBtn =
                    '<a href="'. action('\App\Http\Controllers\Backend\ProjectController@edit', $project) .'" class="edit btn btn-success btn-sm mr-1">'. 'Editar'. '</a>';

                $deleteBtn = '<form method="POST" action="'.action('\App\Http\Controllers\Backend\ProjectController@destroy', $project).'">'.csrf_field().
                    '<input type="hidden" name="_method" value="DELETE">'.
                    '<button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este proyecto?\')">'.
                    'Borrar'.
                    '</button>'.
                    '</form>';

                $action = '<div class="d-flex">'. $editBtn. $deleteBtn. '</div>';
                return $action;
            });

            foreach($this->columns['actions'] as $columnAction) {

            }

            $datatables->rawColumns(['actions'])
                ->make(true);
        }

        return view('backstrap_laravel::admin.crud.index')->with(
            array_merge($this->viewData(), [
                'urlCreate' => $this->getUrl('create'),
                'urlIndex' => $this->getUrl('index'),
            ]),
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}