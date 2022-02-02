<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Rodrigorioo\BackStrapLaravel\CRUD\Traits\Buttons;
use Rodrigorioo\BackStrapLaravel\CRUD\Traits\Cards;
use Rodrigorioo\BackStrapLaravel\CRUD\Traits\Columns;
use Rodrigorioo\BackStrapLaravel\CRUD\Traits\Fields;
use Rodrigorioo\BackStrapLaravel\CRUD\Traits\Validations;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\Controller;
use Rodrigorioo\BackStrapLaravel\CRUD\Http\Requests\CRUDRequest;
use Yajra\DataTables\Facades\DataTables;

abstract class CRUDController extends Controller
{
    use Columns, Buttons, Fields, Cards, Validations;

    protected $model = null;
    protected $modelClass = null;
    protected string $modelName = '';
    protected string $modelNamePlural = '';
    protected array $parameters = [];

    // CRUD attributes

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $buttons = [];

    /**
     * @var array
     *
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected array $validations = [];

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

        // Fields
        $this->addFieldsFromDB($this->modelClass);

        // Validations
        $this->addValidationsFromDB($this->modelClass);

        // Columns
        $this->addColumnsFromDB($this->modelClass);

        // Buttons
        $this->addDefaultButtons();

        // Route parameters
        $this->setRouteParameters();

        // Setup
        // $this->setup();

    }

    public function setRouteParameters () {
        $parameters = Route::getCurrentRoute()->parameters;
        $this->parameters = $parameters;
    }

    public function getUrl ($action, $id = null) {

        // GET ROUTE PARAMETERS
        $parameters = [];
        foreach(Route::getCurrentRoute()->parameters as $nameParameter => $valueParameter) {
            $parameters[] = $valueParameter;
        }

        $url = '';
        $controller = explode('@', Route::currentRouteAction())[0];

        switch($action) {

            case 'index':
            case 'create':
            case 'store':

                $url = action($controller.'@'.$action, array_values($this->parameters));
                break;

            case 'show':
            case 'edit':
            case 'update':
            case 'destroy':

                $url = action($controller.'@'.$action, array_merge(array_values($this->parameters), [$id]));
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

        // Setup
        $this->setupIndex();

        $columns = $this->getColumns();

        if ($request->ajax()) {

            // Raw columns
            $rawColumns = ['actions'];

            // Get elements
            $elements = $this->queryGetModels()->get();

            $datatables = DataTables::of($elements);

            foreach($columns as $columnName => $column) {

                // Set rawcolumns
                if(in_array($column->getType(), ['image'])) {
                    $rawColumns[] = $columnName;
                }

                // Set all columns
                $datatables->addColumn($columnName, function($element) use($columnName, $column, &$rawColumns) {

                    $value = $element->{$columnName};

                    return $column->parseValue($value);
                });
            }

            $datatables->addColumn('actions', function($element) {

                $actions = '<div class="d-flex align-items-center">';

                foreach($this->getButtons() as $buttonName => $button) {

                    // TODO: Refactor and optimize this
                    // Hardcoded buttons
                    switch($buttonName) {

                        case 'edit_button':
                            $this->editButton($buttonName, [
                                'link' => $this->getUrl('edit', $element->id)
                            ]);
                            break;

                        case 'delete_button':
                            $this->editButton($buttonName, [
                                'link' => $this->getUrl('destroy', $element->id)
                            ]);

                            break;
                    }

                    $actions .= $button->render();
                }

                $actions .= '</div>';

                return $actions;
            });

            return $datatables->rawColumns($rawColumns)
                ->make(true);
        }

        // Get column names
        $columnsTable = [];

        foreach($columns as $column) {
            $columnsTable[] = $column->getName();
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
        // Setup
        $this->setupCreate();

        return view('backstrap_laravel::admin.crud.create')->with(
            array_merge($this->viewData(), [
                'urlStore' => $this->getUrl('store'),
                'urlIndex' => $this->getUrl('index'),
                'cards' => $this->getCards(),
                'fields' => $this->getFields(),
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
        // Setup
        $this->setupCreate();

        $request = app(CRUDRequest::class, ['validations' => $this->getValidations()]);

        $fields = $this->getFields();

        $model = new $this->model;
        $model = $this->loadDataToModel($model, $fields, $request);

        if ($model->save()) {
            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::to($this->getUrl('index'))->withAlert(array_merge($alertSuccess, [
                'title' => __('backstrap_laravel::alerts.success.title'),
                'text' => __('backstrap_laravel::alerts.success.text'),
                'close' => __('backstrap_laravel::alerts.success.close'),
            ]));
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::to($this->getUrl('index'))->withAlert(array_merge($alertError, [
            'title' => __('backstrap_laravel::alerts.error.title'),
            'text' => __('backstrap_laravel::alerts.error.text'),
            'close' => __('backstrap_laravel::alerts.error.close'),
        ]));
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

        // Setup
        $this->setupEdit();

        return view('backstrap_laravel::admin.crud.edit')->with(
            array_merge($this->viewData(), [
                'urlUpdate' => $this->getUrl('update', $id),
                'urlIndex' => $this->getUrl('index'),
                'cards' => $this->getCards(),
                'fields' => $this->getFields(),
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
        // Setup
        $this->setupEdit();

        $request = app(CRUDRequest::class, ['validations' => $this->getValidations()]);

        $fields = $this->getFields();

        $model = $this->model::findOrFail($id);
        $model = $this->loadDataToModel($model, $fields, $request);

        if ($model->save()) {
            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::to($this->getUrl('index'))->withAlert(array_merge($alertSuccess, [
                'title' => __('backstrap_laravel::alerts.success.title'),
                'text' => __('backstrap_laravel::alerts.success.text'),
                'close' => __('backstrap_laravel::alerts.success.close'),
            ]));
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::to($this->getUrl('index'))->withAlert(array_merge($alertError, [
            'title' => __('backstrap_laravel::alerts.error.title'),
            'text' => __('backstrap_laravel::alerts.error.text'),
            'close' => __('backstrap_laravel::alerts.error.close'),
        ]));
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

        if ($model->save()) {
            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::to($this->getUrl('index'))->withAlert(array_merge($alertSuccess, [
                'title' => __('backstrap_laravel::alerts.success.title'),
                'text' => __('backstrap_laravel::alerts.success.text'),
                'close' => __('backstrap_laravel::alerts.success.close'),
            ]));
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::to($this->getUrl('index'))->withAlert(array_merge($alertError, [
            'title' => __('backstrap_laravel::alerts.error.title'),
            'text' => __('backstrap_laravel::alerts.error.text'),
            'close' => __('backstrap_laravel::alerts.error.close'),
        ]));
    }

    private function loadDataToModel($model, $fields, Request $request) {

        foreach($fields as $fieldName => $field) {

            $model->{$fieldName} = $field->getValue($request);

//            switch($fieldData['type']) {
//
//                case 'image':
//                case 'file':
//
//                    if($request->file($nameField)) {
//
//                        $uploadFile = config('backstrap_laravel.upload_file');
//                        $file = $request->file($nameField);
//
//                        $fileUrl = $uploadFile['directory'].'/'.$file->store(strtolower($this->modelNamePlural), 'backstrap_laravel');
//
//                        $model->{$nameField} = $fileUrl;
//                    }
//
//                    break;
//
//                default:
//
//                    $model->{$nameField} = $request->{$nameField};
//                    break;
//            }

        }

        return $model;
    }

    public function queryGetModels () {
        return $this->model::latest();
    }

    // SETUPS
    abstract public function setupIndex ();
    abstract public function setupCreate ();
    abstract public function setupEdit ();
}