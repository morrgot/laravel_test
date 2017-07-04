<?php
/**
 * Created by PhpStorm.
 * User: morrgot
 * Date: 03.07.2017
 * Time: 16:03
 */

namespace App\Http\Middleware;

use Closure;

class AfterMiddleware
{

    public function handle($request, Closure $next)
    {
        /** @var \Illuminate\Http\Response $response */
        try {
            $response = $next($request);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            print_r('http exception');
        }

        return $response;
    }
}