<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 05.07.2017
 * Time: 2:01
 */

namespace App\Providers;

class ApiRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Api';

    protected $middlewareGroup = 'api';

    protected $routesFile = 'api_routes.php';
}