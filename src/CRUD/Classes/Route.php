<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

class Route {

    private \Illuminate\Routing\Route $currentRoute;
    private array $queryParameters;


    public function __construct () {

        // Current route
        $this->currentRoute = \Illuminate\Support\Facades\Route::getCurrentRoute();

        // Query parameters
        $queryParameters = request()->query;
        $this->queryParameters = $queryParameters->all();
    }

    public function getUrl ($action, $id = null) {

        $url = '';
        $controller = explode('@', $this->getCurrentRouteAction()['controller'])[0];

        switch($action) {

            case 'index':
            case 'create':
            case 'store':

                $url = action($controller.'@'.$action, array_values($this->getParameters()));
                break;

            case 'show':
            case 'edit':
            case 'update':
            case 'destroy':

                $url = action($controller.'@'.$action, array_merge(array_values($this->getParameters()), [$id]));
                break;
        }

        return $url;
    }

    /**
     * @return \Illuminate\Routing\Route|null
     */
    public function getCurrentRoute(): ?\Illuminate\Routing\Route
    {
        return $this->currentRoute;
    }

    /**
     * @return array
     */
    public function getCurrentRouteAction(): array
    {
        return $this->currentRoute->action;
    }

    /**
     * @return array|null
     */
    public function getParameters(): ?array
    {
        return $this->currentRoute->parameters;
    }

    /**
     * @return array
     */
    public function getQueryParameters(): array
    {
        return $this->queryParameters;
    }


}