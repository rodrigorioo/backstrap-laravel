<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Route as RouteFacade;

class Breadcrumb {

    /**
     * @param $nameOfParameter
     * @param $valueParameter
     * @param $fullRouteName
     * @param $fullRouteParameters
     * @param $lastParam
     * @return array
     *
     * Generate breadcrumb (List and edit) for a parameter route
     */
    private static function getParameterBreadcrumb ($nameOfParameter, $valueParameter, $fullRouteName, $fullRouteParameters, $lastParam = false) {

        $returnBreadcrumbs = [];

        // Parse name of parameters
        $nameOfParameterUpper = Str::ucfirst(Str::camel(Str::replace('_', ' ', $nameOfParameter)));
        $nameOfParameterUpperPlural = Str::plural($nameOfParameterUpper);

        // Make URLS
        $urlIndex = action(RouteFacade::getRoutes()->getByName($fullRouteName.'.index')->action['controller'], array_values($fullRouteParameters));
        $urlEdit = action(RouteFacade::getRoutes()->getByName($fullRouteName.'.edit')->action['controller'], array_merge(array_values($fullRouteParameters), [$valueParameter]));

        $returnBreadcrumbs[] = [
            'text' => __('backstrap_laravel::crud.create.list_of') . $nameOfParameterUpperPlural,
            'url' => $urlIndex,
        ];

        $breadcrumb = [
            'text' => __('backstrap_laravel::crud.edit.breadcrumb_title'),
        ];

        if(!$lastParam) {
            $breadcrumb['url'] = $urlEdit;
        }

        $returnBreadcrumbs[] = $breadcrumb;

        return $returnBreadcrumbs;
    }

    /**
     * @param Route $route
     * @param Model $model
     * @return array
     *
     * Return the complete breadcrumbs array
     */
    public static function generate (Route $route, Model $model) {

        // Var to return
        $breadcrumbs = [];

        // Get parameters of route
        $parameters = $route->getParameters();
        $nameOfParameters = array_keys($parameters);

        // Vars that contains the concatenation of parameters
        $fullRouteName = '';
        $fullRouteParameters = [];

        // Get current action
        $explodeAsActionCurrentRoute = explode('.', $route->getCurrentRoute()->action['as']);
        $currentAction = $explodeAsActionCurrentRoute[count($explodeAsActionCurrentRoute) - 1];
        $currentModel = $explodeAsActionCurrentRoute[count($explodeAsActionCurrentRoute) - 2];

        // Add actual parameter
        switch($currentAction) {

            case 'create':

                // If have one or more parameters
                if(count($nameOfParameters) > 0) {

                    for($i = 0; $i < count($nameOfParameters); $i++) {

                        // Get name and value of parameter
                        $nameOfParameter = $nameOfParameters[$i];
                        $valueParameter = $parameters[$nameOfParameter];

                        // Complete full routes
                        $fullRouteName .= ($fullRouteName != "") ? "." : "";
                        $fullRouteName .= Str::replace('_', '-', Str::plural($nameOfParameter));

                        $generatedBreadcrumbs = self::getParameterBreadcrumb($nameOfParameter, $valueParameter, $fullRouteName, $fullRouteParameters);

                        // Add actual parameter
                        $fullRouteParameters[] = $valueParameter;

                        $breadcrumbs = array_merge($breadcrumbs, $generatedBreadcrumbs);

                    }
                }

                // Complete full routes
                $fullRouteName .= ($fullRouteName != "") ? "." : "";
                $fullRouteName .= Str::replace('_', '-', Str::plural($currentModel));

                $urlIndex = action(RouteFacade::getRoutes()->getByName($fullRouteName.'.index')->action['controller'], array_values($fullRouteParameters));

                // Actual URL
                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.create.list_of') . $model->getModelNamePlural(),
                    'url' => $urlIndex,
                ];

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.create.title'),
                ];

                break;

            case 'edit':

            // If have one or more parameters
            if(count($nameOfParameters) > 0) {

                for($i = 0; $i < count($nameOfParameters); $i++) {

                    // Get name and value of parameter
                    $nameOfParameter = $nameOfParameters[$i];
                    $valueParameter = $parameters[$nameOfParameter];

                    // Complete full routes
                    $fullRouteName .= ($fullRouteName != "") ? "." : "";
                    $fullRouteName .= Str::replace('_', '-', Str::plural($nameOfParameter));

                    $generatedBreadcrumbs = self::getParameterBreadcrumb($nameOfParameter, $valueParameter, $fullRouteName, $fullRouteParameters, $i === count($nameOfParameters) - 1);

                    // Add actual parameter
                    $fullRouteParameters[] = $valueParameter;

                    $breadcrumbs = array_merge($breadcrumbs, $generatedBreadcrumbs);

                }
            }

            break;

            case 'index':

                // If have one or more parameters
                if(count($nameOfParameters) > 0) {

                    for($i = 0; $i < count($nameOfParameters); $i++) {

                        // Get name and value of parameter
                        $nameOfParameter = $nameOfParameters[$i];
                        $valueParameter = $parameters[$nameOfParameter];

                        // Complete full routes
                        $fullRouteName .= ($fullRouteName != "") ? "." : "";
                        $fullRouteName .= Str::replace('_', '-', Str::plural($nameOfParameter));

                        $generatedBreadcrumbs = self::getParameterBreadcrumb($nameOfParameter, $valueParameter, $fullRouteName, $fullRouteParameters);

                        // Add actual parameter
                        $fullRouteParameters[] = $valueParameter;

                        $breadcrumbs = array_merge($breadcrumbs, $generatedBreadcrumbs);

                    }
                }

                $breadcrumbs[] = [
                    'text' => __('backstrap_laravel::crud.index.list_of') . $model->getModelNamePlural(),
                ];

                break;
        }

        return $breadcrumbs;
    }
}