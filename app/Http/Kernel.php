<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class, // Jika kamu memiliki middleware Authenticate
        'role' => \App\Http\Middleware\RoleMiddleware::class, // Middleware Role yang baru
    ];
}
