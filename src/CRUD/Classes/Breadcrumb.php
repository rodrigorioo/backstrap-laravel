<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Route as RouteFacade;

class Breadcrumb {

    private array $breadcrumbs;

    public function __construct () {

        // TODO

    }

    public static function generate ($route) {

        // Var to return
        $breadcrumbs = [];

        // Get parameters of route
        $parameters = $route->getParameters();
        $nameOfParameters = array_keys($parameters);

        // Vars that contains the concatenation of parameters
        $fullRouteName = '';
        $fullRouteParameters = [];

        for($i = 0; $i < count($nameOfParameters); $i++) {

            // Get name and value of parameter
            $nameOfParameter = $nameOfParameters[$i];
            $valueParameter = $parameters[$nameOfParameter];

            // Parse name of parameters
            $nameOfParameterPlural = Str::plural($nameOfParameter);
            $nameOfParameterUpper = Str::ucfirst(Str::camel(Str::replace('_', ' ', $nameOfParameter)));
            $nameOfParameterUpperPlural = Str::plural($nameOfParameterUpper);

            // Complete full routes
            $fullRouteName .= ($fullRouteName != "") ? "." : "";
            $fullRouteName .= Str::replace('_', '-', $nameOfParameterPlural);

            // Actual parameter
            if(count($nameOfParameters) - 1 == $i) {

                // Get current action and evaluate it
                $explodeAsActionCurrentRoute = explode('.', $route->getCurrentRoute()->action['as']);
                $currentAction = $explodeAsActionCurrentRoute[count($explodeAsActionCurrentRoute) - 1];

                switch($currentAction) {

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

                        dd("lol");

                        $breadcrumbs[] = [
                            'text' => __('backstrap_laravel::crud.index.list_of') . $modelNamePlural,
                        ];

                        break;
                }

                // Make URLS
                $urlIndex = action(RouteFacade::getRoutes()->getByName($fullRouteName.'.index')->action['controller'], array_values($fullRouteParameters));
                $urlEdit = action(RouteFacade::getRoutes()->getByName($fullRouteName.'.edit')->action['controller'], array_merge(array_values($fullRouteParameters), [$valueParameter]));

                // Add actual parameter
                $fullRouteParameters[] = $valueParameter;

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.create.list_of') . $nameOfParameterUpperPlural,
                    'url' => $urlIndex,
                ];

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.edit.breadcrumb_title'),
                    'url' => $urlEdit,
                ];


            } else { // If it's not, it's a nest attribute

                // Make URLS
                $urlIndex = action(RouteFacade::getRoutes()->getByName($fullRouteName.'.index')->action['controller'], array_values($fullRouteParameters));
                $urlEdit = action(RouteFacade::getRoutes()->getByName($fullRouteName.'.edit')->action['controller'], array_merge(array_values($fullRouteParameters), [$valueParameter]));

                // Add actual parameter
                $fullRouteParameters[] = $valueParameter;

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.create.list_of') . $nameOfParameterUpperPlural,
                    'url' => $urlIndex,
                ];

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.edit.breadcrumb_title'),
                    'url' => $urlEdit,
                ];

                // TODO:

            }
        }

        // TODO:

        return $breadcrumbs;

//        // Vars
//        $breadcrumbs = [];
//        $urls = [];
//
//        // Add current route to urls
//        $currentRoute = $this->route->getCurrentRoute();
//        $actionCurrentRoute = $currentRoute->action;
//        $controllerCurrentRoute = $currentRoute->controller;
//        $modelNamePlural = $controllerCurrentRoute->modelCrud->getModelNamePlural();
//        $asActionCurrentRoute = $actionCurrentRoute['as'];
//
//        // Add current url to array
//        array_unshift($urls, $asActionCurrentRoute);
//
//        // Explode 'as' name
//        $explodeAsActionCurrentRoute = explode('.', $asActionCurrentRoute);
//
//        // Parameters
//        $parameters = $this->route->getParameters();
//        $currentParameters = [];
//        if(count($parameters) > 0 && $this->isNested) {
//
//            $actualModelName = $controllerCurrentRoute->modelCrud->getModelName();
//
//            foreach($parameters as $nameParameter => $valueParameter) {
//
//                $modelUpperName = str_replace(' ', '', ucwords(str_replace('_', ' ', $nameParameter)));
//                $pluralNameUpper = ltrim(preg_replace('/[A-Z]/', ' $0', $modelUpperName)).'s';
//                $pluralNameLower = ltrim(preg_replace('/[A-Z]/', ' $0', $nameParameter)).'s';
//                $modelName = '\App\Models\\'.$modelUpperName;
//
//                if($modelUpperName == $actualModelName) continue;
//
//                // Add parameter to array
//                $currentParameters[$nameParameter] = $valueParameter;
//
//                // Merge all current route parameters for get the route name
//                $fullRouteName = '';
//                foreach($currentParameters as $nameCurrentParameter => $valueCurrentParameter) {
//                    $fullRouteName .= ($fullRouteName != '') ? '.' : '';
//                    $fullRouteName .= str_replace('_', '-', $nameCurrentParameter).'s';
//                }
//
//                $model = $modelName::findOrFail($valueParameter);
//
//                $urlIndex = action(Route::getRoutes()->getByName($fullRouteName.'.index')->action['controller'], array_values($currentParameters));
//                $urlEdit = action(Route::getRoutes()->getByName($fullRouteName.'.edit')->action['controller'], array_merge(array_values($currentParameters)));
//
//                $breadcrumbs[] = [
//                    'text' => __('backstrap_laravel::crud.create.list_of') . $pluralNameUpper,
//                    'url' => $urlIndex,
//                ];
//
//                $breadcrumbs[] = [
//                    'text' => __('backstrap_laravel::crud.edit.breadcrumb_title'),
//                    'url' => $urlEdit,
//                ];
//            }
//        }
//
//        // Add actual URL
//        switch($explodeAsActionCurrentRoute[count($explodeAsActionCurrentRoute) - 1]) {
//
//            case 'create':
//            case 'edit':
//
//                $urlIndex = action(get_class($controllerCurrentRoute).'@index', $currentParameters);
//
//                $breadcrumbActual = '';
//                if($explodeAsActionCurrentRoute[count($explodeAsActionCurrentRoute) - 1] == 'create') {
//                    $breadcrumbActual = __('backstrap_laravel::crud.create.breadcrumb_title');
//                } else { // If it's edit
//                    $breadcrumbActual = __('backstrap_laravel::crud.edit.breadcrumb_title');
//                }
//
//                array_push($breadcrumbs, [
//                    'text' => __('backstrap_laravel::crud.create.list_of').$modelNamePlural,
//                    'url' => $urlIndex,
//                ], [
//                    'text' => $breadcrumbActual,
//                ]);
//
//                break;
//
//            case 'index':
//
//                $breadcrumbs[] = [
//                    'text' => __('backstrap_laravel::crud.index.list_of') . $modelNamePlural,
//                ];
//
//                break;
//        }
//
//        return $breadcrumbs;
    }

    /**
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }
}