<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Language;
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
    protected bool $isNested = false;

    // CRUD attributes

    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * @var array
     */
    protected array $buttons = [];

    /**
     * @var array
     *
     */
    protected array $cards = [];

    /**
     * @var array
     *
     */
    protected array $fields = [];

    /**
     * @var array
     */
    protected array $validations = [];

    public function __construct () {

        // Model names
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
    }

    private function setRouteParameters () {
        $parameters = Route::getCurrentRoute()->parameters;
        $this->parameters = $parameters;
    }

    private function getUrl ($action, $id = null) {

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

    final private function viewData () {
        return [
            'modelNamePlural' => $this->modelNamePlural,
        ];
    }

    final private function getAllFields () {

        $cards = $this->getCards();
        $fields = $this->getFields();

        foreach($cards as $card) {
            $fields = array_merge($fields, $card->getFields());
        }

        return $fields;
    }

    final private function loadDataToModel($model, $fields, Request $request) {

        foreach($fields as $fieldName => $field) {

            $valueRequest = $field->getValueRequest($request, $model->{$fieldName});

            // If it has translations
            $languages = config('backstrap_laravel.languages');

            if($languages && count($languages) > 0) {

                // If the field is translatable
                if(in_array("Spatie\Translatable\HasTranslations", array_keys(class_uses($model))) && array_key_exists($fieldName, $model->getTranslations())) {
                    $model->setTranslation($fieldName, request('_set_language'), $valueRequest);
                } else {
                    // If it's not, only set the value
                    $model->{$fieldName} = $valueRequest;
                }

            } else {

                // If not have translations, only set the value
                $model->{$fieldName} = $valueRequest;
            }
        }

        return $model;
    }

    final private function generateParentBreadcrumbs () : array
    {
        // Vars
        $breadcrumbs = [];
        $urls = [];

        // Add current route to urls
        $currentRoute = Route::getCurrentRoute();
        $actionCurrentRoute = $currentRoute->action;
        $controllerCurrentRoute = $currentRoute->controller;
        $modelNamePlural = $controllerCurrentRoute->modelNamePlural;
        $asActionCurrentRoute = $actionCurrentRoute['as'];

        // Add current url to array
        array_unshift($urls, $asActionCurrentRoute);

        // Explode 'as' name
        $explodeAsActionCurrentRoute = explode('.', $asActionCurrentRoute);

        // Parameters
        $parameters = $this->parameters;
        $currentParameters = [];
        if(count($parameters) > 0 && $this->isNested) {

            $actualModelName = $controllerCurrentRoute->modelName;

            foreach($parameters as $nameParameter => $valueParameter) {

                $modelUpperName = str_replace(' ', '', ucwords(str_replace('_', ' ', $nameParameter)));
                $pluralNameUpper = $modelUpperName.'s';
                $pluralNameLower = $nameParameter.'s';
                $modelName = '\App\Models\\'.$modelUpperName;

                if($modelUpperName == $actualModelName) continue;

                // Add parameter to array
                $currentParameters[$nameParameter] = $valueParameter;
                
                // Merge all current route parameters for get the route name
                $fullRouteName = '';
                foreach($currentParameters as $nameCurrentParameter => $valueCurrentParameter) {
                    $fullRouteName .= ($fullRouteName != '') ? '.' : '';
                    $fullRouteName .= str_replace('_', '-', $nameCurrentParameter).'s';
                }

                $model = $modelName::findOrFail($valueParameter);

                $urlIndex = action(Route::getRoutes()->getByName($fullRouteName.'.index')->action['controller'], array_values($currentParameters));
                $urlEdit = action(Route::getRoutes()->getByName($fullRouteName.'.edit')->action['controller'], array_merge(array_values($currentParameters)));

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.create.list_of') . $pluralNameUpper,
                    'url' => $urlIndex,
                ];

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.edit.breadcrumb_title'),
                    'url' => $urlEdit,
                ];
            }
        }

        // Add actual URL
        switch($explodeAsActionCurrentRoute[count($explodeAsActionCurrentRoute) - 1]) {

            case 'create':
            case 'edit':

                $urlIndex = action(get_class($controllerCurrentRoute).'@index', $currentParameters);

                $breadcrumbActual = '';
                if($explodeAsActionCurrentRoute[count($explodeAsActionCurrentRoute) - 1] == 'create') {
                    $breadcrumbActual = __('backstrap_laravel::crud.create.breadcrumb_title');
                } else { // If it's edit
                    $breadcrumbActual = __('backstrap_laravel::crud.edit.breadcrumb_title');
                }

                array_push($breadcrumbs, [
                    'text' => __('backstrap_laravel::crud.create.list_of').$modelNamePlural,
                    'url' => $urlIndex,
                ], [
                        'text' => $breadcrumbActual,
                    ]);

                break;

            case 'index':

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.index.list_of') . $modelNamePlural,
                ];

                break;
        }

        return $breadcrumbs;
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
                if(in_array($column->getType(), ['image', 'html'])) {
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

                    $actions .= $button->render($element);
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

        // The last is for action column
        $columnsTable[] = '';

        return view('backstrap_laravel::admin.crud.index')->with(
            array_merge($this->viewData(), [
                'parentBreadcrumbs' => $this->generateParentBreadcrumbs(),
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
    public function create(Request $request)
    {
        // Setup
        $this->setupCreate();

        return view('backstrap_laravel::admin.crud.create')->with(
            array_merge($this->viewData(), [
                'parentBreadcrumbs' => $this->generateParentBreadcrumbs(),
                'urlStore' => $this->getUrl('store'),
                'urlIndex' => $this->getUrl('index'),
                'cards' => $this->getCards(),
                'fields' => $this->getFields(),

                'model' => $this->modelClass,

                'modelClass' => $this->modelClass,
                'languageSelected' => Language::getLanguageSelected($request),
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

        // Make validation request
        $request = app(CRUDRequest::class, ['validations' => $this->getValidations()]);

        // Get all fields (included card fields)
        $fields = $this->getAllFields();

        // Create model
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
    public function show(...$ids)
    {
        $id = end($ids);
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ...$ids)
    {
        $id = end($ids);
        $model = $this->model::findOrFail($id);

        // Setup
        $this->setupEdit();

        return view('backstrap_laravel::admin.crud.edit')->with(
            array_merge($this->viewData(), [
                'parentBreadcrumbs' => $this->generateParentBreadcrumbs(),
                'urlUpdate' => $this->getUrl('update', $id),
                'urlIndex' => $this->getUrl('index'),
                'cards' => $this->getCards(),
                'fields' => $this->getFields(),
                'model' => $model,

                'modelClass' => $this->modelClass,
                'languageSelected' => Language::getLanguageSelected($request),
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
    public function update(Request $request, ...$ids)
    {
        $id = end($ids);

        // Setup
        $this->setupEdit();

        // Make validation request
        $request = app(CRUDRequest::class, ['validations' => $this->getValidations()]);

        // Get all fields (included card fields)
        $fields = $this->getAllFields();

        // Update model
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
    public function destroy(...$ids)
    {
        $id = end($ids);
        $model = $this->model::findOrFail($id);

        if ($model->delete()) {
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

    // Get models for index view
    public function queryGetModels () {
        return $this->model::latest();
    }

    // Setups
    abstract public function setupIndex ();
    abstract public function setupCreate ();
    abstract public function setupEdit ();
}