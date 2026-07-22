<?php
// app/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ...

    protected $routeMiddleware = [
        // ... otros middleware
        'user.active' => \App\Http\Middleware\CheckUserActive::class,
    ];

    // ...
}