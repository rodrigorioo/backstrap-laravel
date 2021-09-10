<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Rodrigorioo\BackStrapLaravel\Http\Requests\CRUD\CRUDRequest;
use Rodrigorioo\BackStrapLaravel\Traits\CRUD\Buttons;
use Rodrigorioo\BackStrapLaravel\Traits\CRUD\Columns;
use Rodrigorioo\BackStrapLaravel\Traits\CRUD\Fields;
use Rodrigorioo\BackStrapLaravel\Traits\CRUD\Validation;
use Yajra\DataTables\Facades\DataTables;

abstract class CRUDController extends Controller
{
    use Columns, Buttons, Fields, Validation;

    protected $model = null;
    protected $modelClass = null;
    protected string $modelName = '';
    protected string $modelNamePlural = '';

    public function __construct () {

        // MODEL NAMES
        if($this->modelName == '') {
            $explodeModel = explode("\\", $this->model);

            $this->modelName = $explodeModel[count($explodeModel) - 1];

            if($this->modelNamePlural == '') {
                $this->modelNamePlural = $this->modelName.'s';
            }
        }

        $this->modelClass = new $this->model;

        // COLUMNS
        $this::addColumnsFromDB($this->modelClass);

        // FIELDS
        $this::addFieldsFromDB($this->modelClass);

        // VALIDATIONS
        $this::addValidationsFromDB($this->modelClass);

        // SETUP
        $this->setup();

    }

    public function getUrl ($action, $id = null) {

        $url = '';
        $controller = explode('@', Route::currentRouteAction())[0];

        switch($action) {

            case 'index':
            case 'create':
            case 'store':

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

            $rawColumns = ['actions'];
            $elements = $this->model::latest()->get();
            $datatables = DataTables::of($elements);

            $columns = $this::getColumns();
            foreach($columns as $columnName => $column) {

                $datatables->addColumn($columnName, function($element) use($columnName, $column) {

                    $value = $element->{$columnName};
                    $returnValue = null;

                     switch($column['type']) {

                         case 'text':

                             $returnValue = $value;
                             break;

                         case 'datetime':

                             $returnValue = Carbon::parse($value)->format('d/m/Y H:i:s');
                             break;

                         case 'date':

                             $returnValue = Carbon::parse($value)->format('d/m/Y');
                             break;
                     }

                     return $returnValue;
                });
            }

            $buttons = $this::getButtons();
            $datatables->addColumn('actions', function($element) use($buttons) {

                $actions = '<div class="d-flex align-items-center">';

                foreach($buttons as $buttonName => $button) {

                    switch($buttonName) {

                        case 'edit_button':

                            $button['html'] = '<a href="'.$this->getUrl('edit', $element->id).'" class="btn btn-success btn-sm mr-1">Editar</a>';
                            break;

                        case 'delete_button':

                            $button['html'] = '<form method="POST" action="'.$this->getUrl('destroy', $element->id).'" class="mr-1">
                                '.csrf_field().'
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="delete btn btn-danger btn-sm" onclick="return confirm(\'Está seguro que desea eliminar este proyecto?\')">
                                Borrar
                                </button>
                                </form>';
                            break;

                        default:

                            break;
                    }

                    $actions .= $button['html'];
                }

                $actions .= '</div>';

                return $actions;
            });

            return $datatables->rawColumns($rawColumns)
                ->make(true);
        }

        $columnsTable = [];

        $columns = $this::getColumns();
        foreach($columns as $columnName => $column) {

            $columnName = $column['name'];

            $columnsTable[] = $columnName;
        }
        $columnsTable[] = '';

        return view('backstrap_laravel::admin.crud.index')->with(
            array_merge($this->viewData(), [
                'urlCreate' => $this->getUrl('create'),
                'urlIndex' => $this->getUrl('index'),
                'columnsTable' => $columnsTable,
                'columns' => $columns,
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
        $fields = $this::getFields();

        return view('backstrap_laravel::admin.crud.create')->with(
            array_merge($this->viewData(), [
                'urlStore' => $this->getUrl('store'),
                'urlIndex' => $this->getUrl('index'),
                'fields' => $fields,
            ]),
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = app(CRUDRequest::class, ['validation' => $this::getValidationCreate()]);

        $fields = $this::getFields();

        $model = new $this->model;
        foreach($fields as $nameField => $fieldData) {

            switch($fieldData['type']) {

                case 'text':

                    $model->{$nameField} = $request->{$nameField};
                    break;
            }

        }

        if ($model->save()) {

            return Redirect::to($this->getUrl('index'))->withAlert([
                'title' => 'Éxito',
                'text' => 'Operación realizada con éxito',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::to($this->getUrl('index'))->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->model::findOrFail($id);
        $fields = $this::getFields();

        return view('backstrap_laravel::admin.crud.edit')->with(
            array_merge($this->viewData(), [
                'urlUpdate' => $this->getUrl('update', $id),
                'urlIndex' => $this->getUrl('index'),
                'fields' => $fields,
                'model' => $model,
            ]),
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = app(CRUDRequest::class, ['validation' => $this::getValidationEdit()]);

        $fields = $this::getFields();

        $model = $this->model::findOrFail($id);

        foreach($fields as $nameField => $fieldData) {

            switch($fieldData['type']) {

                case 'text':

                    $model->{$nameField} = $request->{$nameField};
                    break;
            }

        }

        if ($model->save()) {

            return Redirect::to($this->getUrl('index'))->withAlert([
                'title' => 'Éxito',
                'text' => 'Operación realizada con éxito',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar'
            ]);
        }

        return Redirect::to($this->getUrl('index'))->withAlert([
            'title' => 'Error',
            'text' => 'Error detectado, inténtelo nuevamente',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->model::findOrFail($id);

        if ($model->delete()) {

            return Redirect::to($this->getUrl('index'))->withAlert([
                'title' => 'Éxito',
                'text' => 'Operación realizada con éxito',
                'icon' => 'success',
                'confirm_button_text' => 'Cerrar',
            ]);
        }

        return Redirect::to($this->getUrl('index'))->withAlert([
            'title' => 'Error',
            'text' => 'Ocurrió un error. Volvé a intentarlo',
            'icon' => 'error',
            'confirm_button_text' => 'Cerrar',
        ]);
    }

    abstract public function setup ();
}